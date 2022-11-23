<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Role::factory(1)->create();
        // \App\Models\User::factory(12)->create();
        // \App\Models\Timesheet::factory(120)->create();
        \App\Models\Project::factory(5)->create();
    }
}
