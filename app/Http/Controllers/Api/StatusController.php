<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\StatusResource;
use App\Models\Status;
use App\Repositories\StatusRepository;
use App\Utils\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Log;

class StatusController extends Controller
{
    protected $statusRepository;

    public function __construct(StatusRepository $statusRepository)
    {
        $this->statusRepository = $statusRepository;
    }

    public function index(Request $request)
    {

        Log::info('show request get status:', ['request' => $request->all()]);
        if($request->type == 0){
            $statuses = $this->statusRepository->paginated(8);
        }else if($request->type == 1){
            $statuses=$this->statusRepository->statusMaster();
        }else{
            $statuses = $this->statusRepository->all();
        }
        Log::info('Showing for statuses:', ['statuses' => $statuses]);
        return response()->json($statuses);
    }

//    public function getAll(Request $request)
//    {
//
//        Log::info('Showing for statuses:', ['statuses' => $statuses]);
//        return response()->json($statuses);
//    }

    public function store(AddStatusRequest $request)
    {
        $status = $this->statusRepository->create($request->all());
        return response()->json(new JsonResponse(new StatusResource($status)), Response::HTTP_OK);
    }

    public function show($id)
    {

        $statuses = $this->statusRepository->domain($id);
        return response()->json($statuses);
    }

    public function update(UpdateStatusRequest $request, Status $status)
    {

        $status = $this->statusRepository->update($status->id, $request->all());
        return response()->json(new JsonResponse(new StatusResource($status)), Response::HTTP_OK);

    }

    public function destroy(Status $status)
    {
        $this->statusRepository->destroy($status->id);
        return response()->json(new JsonResponse(new StatusResource($status)), Response::HTTP_OK);

    }
//    public function showStatusMaster()
//    {
//
//        return response($statusMaster);
//    }
}
