<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class seedData extends Command
{
    protected $signature = 'seed:all';
    protected $description = 'Seed the database with users, categories, and courses.';

    public function handle()
    {
        $this->call('db:seed', ['--class' => 'UserSeeder']);
        $this->call('db:seed', ['--class' => 'CategorySeeder']);
        $this->call('db:seed', ['--class' => 'CourseSeeder']);

        $this->info('All data seeded successfully.');
    }
}
