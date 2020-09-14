<?php

namespace App\Repositories;

use App\Models\Workplace;
use Carbon\Carbon;

class WorkplaceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Workplace $workplace)
    {
        $this->model = $workplace;
    }
    public function workplaceBefore($userID)
    {
        return $this->model->latest('id')->where('user_id',$userID)->first();
    }

    public function getWorkplaceByDate( $date)
    {
        return $this->model->where('time_finish','like',$date .'%')->orWhere('created_at','like', $date.'%')->with('place')->get();

    }

    public function createWorkplace($input)
    {
        $model = $this->model;
        $model->fill($input);
        $model->save();

        return $model->where('time_finish',Carbon::now())->with('place')->orderBy('id')->first();
    }
}
