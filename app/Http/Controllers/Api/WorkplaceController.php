<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddStatusRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\StatusResource;
use App\Repositories\StatusRepository;
use App\Services\WorkplaceService;
use Illuminate\Http\Request;
use App\Http\Requests\AddWorkPlaceRequest;
use App\Http\Resources\WorkplaceResource;
use App\Repositories\WorkplaceRepository;
use App\Utils\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Log;
use Carbon\Carbon;
use DB;

class WorkplaceController extends Controller
{
    protected $workplaceRepository;
    protected $workplaceService;

    public function __construct(WorkplaceRepository $workplaceRepository, WorkplaceService $workplaceService)
    {
        $this->workplaceRepository = $workplaceRepository;
        $this->workplaceService = $workplaceService;
    }

    public function index()
    {
        $workplaces = $this->WorkplaneRepository->all();
        return response()->json(new JsonResponse(StatusResource::collection($workplaces)), Response::HTTP_OK);
    }

    public function store(AddWorkPlaceRequest $request)
    {
        Log::info('show request add workplace:',['request' => $request->all()]);
        $workplace = $this->workplaceService->store($request);
        Log::info('Showing for workplace:', ['workplace' => $workplace]);
        return response()->json($workplace);
//        return response()->json(new JsonResponse(new ActivityResource($workplace)), Response::HTTP_OK);
    }
}
