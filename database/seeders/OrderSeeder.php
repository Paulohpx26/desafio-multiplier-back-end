<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '1536M');//allocate memory
        DB::disableQueryLog();//disable log

        $faker = Faker::create();
        foreach (range(1,400) as $value) {
            $data = [];

            foreach (range(1,1000) as $subValue) {
                $status = 'completed';
                if ($value > 398)
                    $status = 'pending';
                if ($value > 399)
                    $status = 'processing';

                array_push($data, [
                    'client_id' => rand(1,1000),
                    'table_id' => rand(1,25),
                    'menu_id' => rand(1,40),
                    'quantity' => $faker->randomDigit,
                    'status' => $status,
                    'waiter_id' => rand(2,10),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            DB::table('orders')->insert($data);
        }
    }
}
