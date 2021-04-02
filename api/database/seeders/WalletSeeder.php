<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallets')->insert([
            'owner' => password_hash('a@test.com:12345678912', PASSWORD_DEFAULT),
            'value' => 100
        ]);

        DB::table('wallets')->insert([
            'owner' => password_hash('b@test.com:78945612378', PASSWORD_DEFAULT),
            'value' => 100
        ]);

        DB::table('wallets')->insert([
            'owner' => password_hash('c@test.com:12345678000190', PASSWORD_DEFAULT),
            'value' => 50
        ]);

        DB::table('wallets')->insert([
            'owner' => password_hash('d@test.com:98765432000110', PASSWORD_DEFAULT),
            'value' => 0
        ]);
    }
}
