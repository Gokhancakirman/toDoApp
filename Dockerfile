FROM php:8.2-fpm-alpine

# Install system dependencies 2
RUN apk update && apk upgrade && apk add git zip unzip wget libpng-dev libxml2-dev alien nano

# Install PHP extensions
RUN set -ex; \
	\
	apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		freetype-dev \
		libjpeg-turbo-dev \
		libpng-dev \
		libzip-dev \
        oniguruma-dev \
	; \
	\
	docker-php-ext-configure gd; \
	docker-php-ext-install -j "$(nproc)" \
		bcmath \
		exif \
		gd \
		mysqli \
		zip \
        pdo_mysql \
        mbstring \
        pcntl \
	; \
	pecl install redis; \
	docker-php-ext-enable redis; \
	rm -r /tmp/pear; \
	\
	runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-network --virtual .wordpress-phpexts-rundeps $runDeps; \
	apk del --no-network .build-deps; \
    mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini;  \
    sed -i 's/pm.max_children = 5/pm.max_children = 128/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/pm.start_servers = 2/pm.start_servers = 32/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/pm.min_spare_servers = 1/pm.min_spare_servers = 32/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/pm.max_spare_servers = 3/pm.max_spare_servers = 96/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/;pm.process_idle_timeout = 10s/pm.process_idle_timeout = 6s/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/;request_slowlog_timeout = 0s/request_slowlog_timeout = 3s/g' /usr/local/etc/php-fpm.d/www.conf;  \
    sed -i 's/max_execution_time = 30/max_execution_time = 120/g' /usr/local/etc/php/php.ini;  \
    sed -i 's/max_input_time = 60/max_input_time = -1/g' /usr/local/etc/php/php.ini;  \
    sed -i 's/post_max_size = 8M/post_max_size = 128M/g' /usr/local/etc/php/php.ini;  \
    curl -sS https://getcomposer.org/installer -o composer-setup.php;  \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer;

USER www-data:www-data
WORKDIR /var/www/php
COPY --chown=www-data . /var/www/php

USER root

RUN rm -rf docker Dockerfile Dockerfile-nginx Dockerfile_supervisor .env* *.sh  \
    docker-compose.yml .git* html .idea .DS_Store docker-volumes
