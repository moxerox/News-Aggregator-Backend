<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the initial setup for the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->comment('Migrating database');
        $this->resetMigrations();
        $this->info('Database migrated & Seeded');

        $this->comment('Installing Laravel Passport');
        $this->installPassport();
        $this->info('Passport installed');

//        $this->comment('Seeding Database');
//        $this->resetMigrations();
//        $this->info('Seed Completed');
    }

    public function resetMigrations()
    {
        Artisan::call('migrate:fresh --seed');
    }

    public function seedDatabase()
    {
//        Artisan::call('db:seed');
    }

    public function installPassport()
    {
        Artisan::call('passport:install');
    }
}
