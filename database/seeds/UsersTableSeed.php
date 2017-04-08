<?php

use Illuminate\Database\Seeder;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'VP_Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(123456),
        ]);
        DB::table('users')->insert([
            'name' => 'Tùng Béo',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt(123456),
        ]);

    }
}
