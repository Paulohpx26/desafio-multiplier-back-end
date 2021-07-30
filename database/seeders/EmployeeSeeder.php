<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('pt_BR');
        foreach (range(1,15) as $value) {
            $role = $value <= 10 ? 'waiter' : 'cooker';

            if ($value === 1)
                $role = 'administrator';

            $cpf = preg_replace('/[^0-9]/', '', $faker->cpf);
            $employee = Employee::create([
                'name' => $faker->name,
                'cpf' => $cpf,
                'password' => bcrypt('123456'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $employee->assignRole($role);
        }
    }
}
