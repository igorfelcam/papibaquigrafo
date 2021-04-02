<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'      => 'Abcd Efgh',
            'email'     => 'a@test.com',
            'document'  => '12345678912',
            'password'  => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name'      => 'Bcde Fghi',
            'email'     => 'b@test.com',
            'document'  => '78945612378',
            'password'  => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name'      => 'Cdef Ghij',
            'email'     => 'c@test.com',
            'document'  => '12345678000190',
            'password'  => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'name'      => 'Defg Hijk',
            'email'     => 'd@test.com',
            'document'  => '98765432000110',
            'password'  => Hash::make('password'),
        ]);
    }
}
