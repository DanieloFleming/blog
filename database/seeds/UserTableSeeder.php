<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username'   => config('auth.admin.name'),
            'email'      => config('auth.admin.email'),
            'password'   => Hash::make('black ops'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
