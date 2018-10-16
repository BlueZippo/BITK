<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@biltk.com',
            'created_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('secret'),
        ]);

        DB::table('roles')->insert([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);
    }
}
