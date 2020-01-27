<?php

use Illuminate\Database\Seeder;

class default_users_table_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'email' => 'admin@loyaltycreditasia.com',
                'role_id' => 1,
                'mobile_number' => NULL,
                'establishment_name' => NULL,
            ]
        ]);
    }
}
