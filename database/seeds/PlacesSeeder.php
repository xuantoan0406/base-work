<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = [
            [
                "place" => "横浜",
                "color" => "#F8B62D"
            ],
            [
                "place" => "厚木",
                "color" => "#7EA8D2"
            ],
            [
                "place" => "山梨",
                "color" => "#8EC54A"
            ],
            [
                "place" => "大阪",
                "color" => "#F19C9F"
            ],
            [
                "place" => "大分",
                "color" => "#B06CAA"
            ],
            [
                "place" => "自宅",
                "color" => "#5AA295"
            ],
            [
                "place" => "外出先",
                "color" => "#ED6D3D"
            ]
        ];
        DB::table('places')->insert($places);
    }
}
