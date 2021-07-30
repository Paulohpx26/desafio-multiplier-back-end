<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuSeeder::class,
            TableSeeder::class,
            ClientSeeder::class,
            RoleSeeder::class,
            EmployeeSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
