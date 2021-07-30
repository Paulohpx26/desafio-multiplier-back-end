<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '512M');//allocate memory
        DB::disableQueryLog();//disable log

        $faker = Faker::create('pt_BR');
        foreach (range(1,10) as $value) {
            $data = [];

            foreach (range(1,1000) as $subValue) {
                $cpf = preg_replace('/[^0-9]/', '', $faker->cpf);
                array_push($data, [
                    'name' => $faker->name,
                    'cpf' => $cpf,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::table('clients')->insert($data);
        }

    }
}
