<?php

namespace App\Services;

use App\Utils\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkplaceRepository;
use Log;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class UserService
{
    protected $userRepository;
    protected $activityRepository;
    protected $workplaceRepository;
    public function __construct(ActivityRepository $activityRepository, UserRepository $userRepository, WorkplaceRepository $workplaceRepository ) {
        $this->userRepository = $userRepository;
        $this->activityRepository = $activityRepository;
        $this->workplaceRepository = $workplaceRepository;
    }

    public function getListUsersWithActivity(Request $request)
    {
        Log::info('request page:', ['request' => $request->all()]);
        $users = $this->userRepository->paginated(10);
        Log::info('Showing for users paginated:', ['users' => $users]);
//        them truong activityByDate
//        $activityByDate = ActivityController::getActivityByDate();
        $activityByDate = $this->activityRepository->getActivityByDate( $request->date);
        Log::info('Showing for activityByDate:', ['activityByDate' => $activityByDate]);
        //
        $users->data = $users->map(function($user) use ($activityByDate) {
            $activity = $activityByDate->where('user_id', $user->id)->all();
            Log::info('Showing for user:', ['user' => $user]);
            $user->activityByDate = $activity ? $activity : '';
            return $user;
        });
        return $users;
//        return response()->json($users);
    }

    public function getListUsersWithWorkplaces(Request $request)
    {
        Log::info('request page:', ['request' => $request->all()]);
        $users = $this->userRepository->paginated(10);
        Log::info('Showing for users paginated:', ['users' => $users]);

//        them truong workplaceByDate
        $workplaceByDate = $this->workplaceRepository->getworkplaceByDate( $request->date);
        Log::info('Showing for activityByDate:', ['activityByDate' => $workplaceByDate]);
        $users->data = $users->map(function($user) use ($workplaceByDate) {
            $workplace = $workplaceByDate->where('user_id', $user->id)->all();
            Log::info('Showing for user:', ['user' => $user]);
            $user->workplaceByDate = $workplace ? $workplace : '';
            return $user;
        });
        return $users;
    }

    public function getListUserFilterByStatus(Request $request)
    {
        Log::info('request page:', ['request' => $request->all()]);
        $users = $this->userRepository->all();
        Log::info('Showing for users paginated:', ['users' => $users]);

        //        them truong activityByDate
//        $activityByDate = ActivityController::getActivityByDate();
        $activityByDate = $this->activityRepository->getActivityByDate( $request->date);
        Log::info('Showing for activityByDate:', ['activityByDate' => $activityByDate]);
        //
        $users->data = $users->map(function($user) use ($activityByDate) {
            $activity = $activityByDate->where('user_id', $user->id)->all();
            Log::info('Showing for user:', ['user' => $user]);
            $user->activityByDate = $activity ? $activity : '';
            return $user;
        });

        Log::info('getListUserFilterByStatus:', ['users' => $users]);
        $usersList = $users->data;
        $listUsers = [];
        for ($i = 0; $i < count($usersList); $i++) {
            Log::info($i);
            if( $usersList[$i]->activityByDate){
                $activityByDate = $usersList[$i]->activityByDate;
//                Log::info($activityByDate);
               $lastAct =  array_pop($activityByDate);
                Log::info('lastAct', ['lastAct' => $lastAct]);
                if($lastAct->status_id == $request->status_id){
                    array_push($listUsers,$usersList[$i]);
                }
            }
        }
        $page = 1;
        $perPage = 10;
        $listUsers = collect($listUsers);
        $paginator = new Paginator(
            $listUsers->forPage($page, $perPage),
            $listUsers->count(),
            $perPage,
            $page,
            ['path' => url('/api/getListUserFilterByStatus')]
        );
        return $paginator;
    }

    public function getUsersOrderByName(Request $request)
    {
        Log::info('request page:', ['request' => $request->all()]);
        $users = $this->userRepository->orderByName(10);
        Log::info('Showing for users paginated:', ['users' => $users]);
//        them truong activityByDate
//        $activityByDate = ActivityController::getActivityByDate();
        $activityByDate = $this->activityRepository->getActivityByDate( $request->date);
        Log::info('Showing for activityByDate:', ['activityByDate' => $activityByDate]);
        //
        $users->data = $users->map(function($user) use ($activityByDate) {
            $activity = $activityByDate->where('user_id', $user->id)->all();
            Log::info('Showing for user:', ['user' => $user]);
            $user->activityByDate = $activity ? $activity : '';
            return $user;
        });
        return $users;
    }
}
