<?php

use Illuminate\Database\Seeder;

class CustomersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
        	'name' 		=> 'Tùng Béo',
        	'gender' 	=> 1,
        	'age' 		=> '23',
        	'address' 	=> 'Hà nội',
        ]);
        DB::table('customers')->insert([
        	'name' 		=> 'Minh Gay',
        	'gender' 	=> 1,
        	'age' 		=> '23',
        	'address' 	=> 'Hà nội',
        ]);
        DB::table('customers')->insert([
        	'name' 		=> 'Tuấn Việt',
        	'gender' 	=> 1,
        	'age' 		=> '23',
        	'address' 	=> 'Hà nội',
        ]);

    }
}
