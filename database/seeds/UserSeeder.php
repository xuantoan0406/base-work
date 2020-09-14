<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                "email" => "domain5",
                "domain_id"=>1,
                "main_company"=>'aa'
            ],
            [
                "email" => "domain6",
                "domain_id"=>2,
                "main_company"=>'bb'
            ],
        ];
        DB::table('users')->insert($users);
    }
}
