
# To do app

Projeyi çalıştırmak için make:install komutunu çalıştırınız. Make:install komutu projenin docker üzerinden çalıştırılmasını, composer paketlerinin kurulmasını , database migration ve seed işlemlerini gerçekleştirir.

Yeni bir provider eklemek için

http://localhost:8000 adresinden uygulamayı çalıştırabilirsiniz.

### Provider 1 formatında ekleme yapmak için

make bash

php artisan provider:add --name=Provider3 --url=http://test.com --parameters=id,zorluk,sure

### Provider 2 formatında ekleme yapmak için

make bash

php artisan provider:add --name=Provider3 --url=http://test.com --parameters={key},level,estimated_duration

Provider için eklenen api içindeki parametrelere göre parameters kısmını güncellemeniz gerekir.

### Unit test çalıştırılması

Unit test işlemini gerçekleştirmek için 

make test komutunu

veya

make bash

php artisan test

komutlarını çalıştırabilirsiniz.


