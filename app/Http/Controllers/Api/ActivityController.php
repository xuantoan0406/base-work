<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
//use Illuminate\Http\Request;
use App\Http\Requests\AddActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Repositories\ActivityRepository;
use App\Services\ActivityService;
use App\Utils\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Log;
use Carbon\Carbon;
use DB;


class ActivityController extends Controller
{
    protected $activityRepository;
    protected $activityService;

    public function __construct(ActivityRepository $activityRepository,ActivityService $activityService)
    {
        $this->activityRepository = $activityRepository;
        $this->activityService = $activityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = $this->activityRepository->all();
        return response()->json(new JsonResponse(ActivityResource::collection($activities)), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddActivityRequest $request)
    {
        Log::info('show request add activity:',['request' => $request->all()]);

        $activity = $this->activityService->store($request);
        Log::info('Showing for activity:', ['activity' => $activity]);
        return response()->json($activity);
//        return response()->json(new JsonResponse(new ActivityResource($activity)), Response::HTTP_OK);
    }

    public function endActivity(Request $request)
    {
        $activity = $this->activityService->endActivity($request);
        Log::info('Showing for activity:', ['activity' => $activity]);
        return response()->json($activity);
    }

    public function getActInFourDaysPrevious(Request $request)
    {
        Log::info('show request getActFourDaysPrevious :',['request' => $request->all()]);
        $activities = $this->activityService->getActInFourDaysPrevious($request);
        return response()->json($activities);
    }

    public function getActivityByUser(AddActivityRequest $request)
    {
        Log::info('show request getActivityByDate :',['request' => $request->all()]);
        $activities = $this->activityRepository->getActivityByDate( $request->date);
        Log::info(print_r($activities, true));
        return response()->json(new JsonResponse(ActivityResource::collection($activities)), Response::HTTP_OK);
    }

    public function getActTodayByAuth(Request $request)
    {
        $activities = $this->activityRepository->getActTodayByAuth( $request->date);
        Log::info(print_r($activities, true));
        return response()->json(new JsonResponse(ActivityResource::collection($activities)), Response::HTTP_OK);
    }

    public function getActOfMonth(Request $request)
    {
        $activity = $this->activityService->getActOfMonth($request);
        Log::info('Showing for getActOfMonth:', ['activity' => $activity]);
        return response()->json($activity);
    }




}
