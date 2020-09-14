<?php

namespace App\Services;

use App\Http\Requests\AddActivityRequest;
use App\Utils\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Repositories\ActivityRepository;
use Illuminate\Support\Facades\Auth;
use Log;

class ActivityService
{
    protected $userRepository;
    protected $activityRepository;
    public function __construct(ActivityRepository $activityRepository) {
        $this->activityRepository = $activityRepository;
    }

    public function store(AddActivityRequest $request)
    {
        $activityRequest = [
            'user_id' => $request->userID,
            'status_id' => $request->statusID,
            'time_finish' => Carbon::now(),
            'domain_id' => Auth::user()->domain_id,
            'created_at' => Carbon::now(),
        ];
        $activityBefore = $this->activityRepository->activityBefore($request->userID);

        // update time_finish
        if($activityBefore){
            Log::info('Showing for activityBefore:', ['activityBefore' => $activityBefore->created_at->toDateString()]);
            if($activityBefore->created_at->toDateString() != Carbon::now()->toDateString()){
                $updateTimeFinish = [
                    'time_finish' => $activityBefore->created_at->setTime(21, 0, 0)
                ];
            }else if($activityBefore->created_at == $activityBefore->time_finish ) {
                $updateTimeFinish = [
                    'time_finish' => Carbon::now()
                ];
            }else {
                $updateTimeFinish = [];
            };

            $this->activityRepository->update($activityBefore->id, $updateTimeFinish );
        }

        $activity = $this->activityRepository->createActivity($activityRequest);
        Log::info('Showing for activity from ActivityService:', ['activity' => $activity]);
        return $activity;
//        return response()->json($users);
    }

    public function endActivity(Request $request)
    {
        $activityBefore = $this->activityRepository->activityBefore($request->userID);
        if($activityBefore){
            Log::info('Showing for activityBefore:', ['activityBefore' => $activityBefore->created_at->toDateString()]);
            if($activityBefore->created_at->toDateString() == Carbon::now()->toDateString()){
                $updateTimeFinish = [
                    'time_finish' => Carbon::now()
                ];
                $this->activityRepository->update($activityBefore->id, $updateTimeFinish);
            }
        }
        return $activityBefore;
    }

    public function getActOfMonth(Request $request)
    {
        Log::info('show request getActOfMonth :',['request' => $request->all()]);
        $daysInMonth = $this->activityRepository->daysInMonth($request->user_id,$request->month);
        Log::info('Showing for users paginated:', ['daysInMonth' => $daysInMonth]);
        // them truong activityByDate
        $getActivityByUserWithMonth = $this->activityRepository->getActivityByUserWithMonth($request->user_id, $request->month);
        Log::info('Showing for getActivityByUserWithMonth:', ['getActivityByUserWithMonth' => $getActivityByUserWithMonth]);
        //
        $daysInMonth->data = $daysInMonth->map(function($dayInMonth) use ($getActivityByUserWithMonth) {
            Log::info('Showing for dayInMonth:', ['activity' => $dayInMonth->date ]);
            $activity = $getActivityByUserWithMonth->where('date', $dayInMonth->date)->all();
            Log::info('Showing for $activity:', ['activity' => $activity]);
            $dayInMonth->activityByDate = $activity ? $activity : '';
            return $dayInMonth;
        });
        return $daysInMonth;
    }

    public function getActInFourDaysPrevious(Request $request)
    {
        $fourDaysPrevious = $this->activityRepository->fourDaysPrevious($request->userID);
        Log::info('Showing for users fourDaysPrevious:', ['fourDaysPrevious' => $fourDaysPrevious]);
        // them truong activityByDate
        $getActivityByUserWithFourDaysPrevious = $this->activityRepository->getActivityByUserWithFourDaysPrevious($request->userID);
        Log::info('Showing for getActivityByUserWithMonth:', ['getActivityByUserWithMonth' => $getActivityByUserWithFourDaysPrevious]);
        //
        $fourDaysPrevious->data = $fourDaysPrevious->map(function($day) use ($getActivityByUserWithFourDaysPrevious) {
            Log::info('Showing for dayInMonth:', ['activity' => $day->date ]);
            $activity = $getActivityByUserWithFourDaysPrevious->where('date', $day->date)->all();
            Log::info('Showing for $activity:', ['activity' => $activity]);
            $day->activityByDate = $activity ? $activity : '';
            return $day;
        });
        return $fourDaysPrevious;
    }
}
