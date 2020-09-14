<?php

namespace App\Repositories;

use App\Models\Activity;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Log;
class ActivityRepository extends BaseRepository
{
    protected $model;

    public function __construct(Activity $activity)
    {
        $this->model = $activity;
    }

    public function activityBefore($userID)
    {
        return $this->model->latest('id')->where('user_id',$userID)->first();
    }

    public function getActivityByDate( $date)
    {
        return $this->model->where('time_finish','like',$date .'%')->orWhere('created_at','like', $date.'%')->with('status')->get();
    }

    public function createActivity($input)
    {
        $model = $this->model;
        $model->fill($input);
        $model->save();

        return $model->where('time_finish',Carbon::now())->with('status')->orderBy('id')->first();
    }

    public function getActivityByUser($userID)
    {
        return $this->model->where('user_id',$userID)->get();
    }

    public function getActTodayByAuth()
    {
        return $this->model->where('user_id',Auth::user()->id)->whereDate('created_at', Carbon::now())->get();
    }

    public function daysInMonth($userID,$month)
    {
//      return $this->model->select('created_at')->where('user_id',$userID)->where('created_at','like',$month .'%')->groupBy('created_at')->get();
        $dayHis = Activity::selectRaw("DATE_FORMAT(created_at, '%Y %m %e') date")
            ->where('user_id',$userID)->where('created_at','like',$month .'%')
            ->where('created_at','<', Carbon::today())
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $dayHis;
    }

    public function getActivityByUserWithMonth( $userID, $month)
    {
//        return $this->model->where('user_id',$userID)->where('created_at','like', $month.'%')->get();
        $actHis = Activity::selectRaw("*,DATE_FORMAT(created_at, '%Y %m %e') date")
            ->where('user_id',$userID)->where('created_at','like',$month .'%')
            ->with('status')
            ->get();
        return $actHis;
    }

    public function fourDaysPrevious($userID)
    {
        $fourDaysPrevious = Activity::selectRaw("DATE_FORMAT(created_at, '%Y-%m-%e') date")
            ->where('user_id',$userID)->whereDate('created_at','<', Carbon::today())->whereDate('created_at','>', Carbon::now()->subDays(5))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
        return $fourDaysPrevious;
    }

    public function getActivityByUserWithFourDaysPrevious($userID)
    {
        $act = Activity::selectRaw("*,DATE_FORMAT(created_at, '%Y-%m-%e') date")
            ->where('user_id',$userID)
            ->whereDate('created_at','<', Carbon::today())->whereDate('created_at','>', Carbon::now()->subDays(5))
            ->with('status')
            ->get();
        return $act;
    }

}
