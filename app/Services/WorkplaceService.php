<?php

namespace App\Services;

use App\Http\Requests\AddWorkPlaceRequest;
use App\Utils\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Repositories\workplaceRepository;
use Illuminate\Support\Facades\Auth;
use Log;

class WorkplaceService
{
    protected $userRepository;
    protected $workplaceRepository;
    public function __construct(workplaceRepository $workplaceRepository) {
        $this->workplaceRepository = $workplaceRepository;
    }

    public function store(AddWorkPlaceRequest $request)
    {
        $workplaceRequest = [
            'user_id' => $request->userID,
            'place_id' => $request->placeID,
            'time_finish' => Carbon::now(),
            'domain_id' => Auth::user()->domain_id,
        ];
        $workplaceBefore = $this->workplaceRepository->workplaceBefore($request->userID);
//        Log::info('Showing for activityBefore:', ['activityBefore' => $workplaceBefore->created_at->toDateString()]);

        if($workplaceBefore){
            if($workplaceBefore->created_at->toDateString() != Carbon::now()->toDateString()){
                $updateTimeFinish = [
                    'time_finish' => Carbon::yesterday()->setTime(21, 0, 0)
                ];
            }else {
                $updateTimeFinish = [
                    'time_finish' => Carbon::now()
                ];
            }
            $this->workplaceRepository->update($workplaceBefore->id, $updateTimeFinish );
        }

        $workplace = $this->workplaceRepository->createWorkplace($workplaceRequest);
        Log::info('Showing for activity from ActivityService:', ['activity' => $workplace]);
        return $workplace;

//        return response()->json($users);
    }
}
