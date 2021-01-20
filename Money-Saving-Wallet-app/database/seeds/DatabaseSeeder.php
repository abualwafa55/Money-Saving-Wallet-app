<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

      DB::table('currencies')->insert([[
        'code' => 'EUR',
        'currency' => 'Euro',
        'state' => 'EUR',
      ],[
        'code' => 'JOD',
        'currency' => 'Jordanian dinar',
        'state' => 'Jordan',
      ],[
        'code' => 'GBP',
        'currency' => 'British pound',
        'state' => 'UK',
      ],[
        'code' => 'USD',
        'currency' => 'United States dollar',
        'state' => 'USA',
      ]]);
    }
}
