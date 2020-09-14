<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Utils\JsonResponse;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Log;

class UserController extends Controller
{
    protected $userRepository;
    protected $userService;

    public function __construct(UserRepository $userRepository, UserService $userService)
    {
        $this->userRepository = $userRepository;
        $this->userService = $userService;
    }

    public function getListUsersWithActivity(Request $request)
    {
        Log::info('show request add activity:',['request' => $request->all()]);
        $users = $this->userService->getListUsersWithActivity($request);
        Log::info('Showing for user getListUsersWithActivity:', ['users' => $users]);
        return response()->json($users);
//        return response()->json(new JsonResponse(UserResource::collection($users)), Response::HTTP_OK);
    }

    public function getListUserFilterByStatus(Request $request)
    {
        Log::info('getListUserFilterByStatus controller:',['request' => $request->all()]);
        $users = $this->userService->getListUserFilterByStatus($request);
//        return $users;
        return response()->json($users);
    }

    public function getUsersOrderByName(Request $request)
    {
        $users = $this->userService->getUsersOrderByName($request);
        return response()->json($users);
    }

    public function getListUsersWithWorkplaces(Request $request)
    {
        Log::info('show request add activity:',['request' => $request->all()]);
        $users = $this->userService->getListUsersWithWorkplaces($request);
        Log::info('Showing for user:', ['users' => $users]);
        return response()->json($users);
//        return response()->json(new JsonResponse(UserResource::collection($users)), Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $input = $request->all();

        if ($request->has('avatar')) {
            $imagePath = $request->avatar->store('avatar', 'public');
            $input = array_merge($request->all(), ['avatar' => $imagePath]);
        }

        $user = $this->userRepository->update($user->id, $input);
        return response()->json(new JsonResponse(new UserResource($user)), Response::HTTP_OK);
    }
    public function updateInformation(Request $request){

            $information=$this->userRepository->updateInformation($request);
        return response()->json($information);
    }
    public function show($id){
        $user=$this->userRepository->showUser($id);
        return response()->json($user);
    }

}
