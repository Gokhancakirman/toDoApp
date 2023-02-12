<?php

namespace App\Console\Commands;

use App\Services\Provider\ProviderManager;
use Illuminate\Console\Command;

class AddProviderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'provider:add {--name=} {--url=} {--parameters=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Provider';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = ProviderManager::createProviderService($this->option('url'),$this->option('name'),$this->option('parameters'));
        $provider->saveProviders();
        echo "{$this->option('name')} added succesfully\n";
        return Command::SUCCESS;
    }
}
