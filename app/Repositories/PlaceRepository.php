<?php

namespace App\Repositories;

use App\Models\Place;

class PlaceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Place $place)
    {
        $this->model = $place;
    }

}
