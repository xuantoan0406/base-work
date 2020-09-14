<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [

            [
                "status" => "テレワーク",
                "color" => "#ED6D3D",
                "domain_id" => 1,
                "master" => false,
            ],
            [
                "status" => "着席中",
                "color" => "#F8B62D",
                "domain_id" => 1,
                "master" => false
            ],
            [
                "status" => "離席中",
                "color" => "#7EA8D2",
                "domain_id" => 1,
                "master" => false
            ],
            [
                "status" => "取込中",
                "color" => "#8EC54A",
                "domain_id" => 1,
                "master" => false
            ],
            [
                "status" => "離席中",
                "color" => "#F19C9F",
                "domain_id" => 1,
                "master" => true
            ],
            [
                "status" => "移動中",
                "color" => "#B06CAA",
                "domain_id" => 2,
                "master" => false
            ],
            [
                "status" => "商談中",
                "color" => "#5AA295",
                "domain_id" => 2,
                "master" => false
            ],
            [
                "status" => "テレワーク",
                "color" => "#ED6D3D",
                "domain_id" => 2,
                "master" => true
            ]
        ];
        DB::table('statuses')->insert($statuses);
    }
}
