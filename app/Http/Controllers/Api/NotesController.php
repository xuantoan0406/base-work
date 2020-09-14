<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\JsonResponse;
use Illuminate\Http\Request;
use App\Repositories\NotesRepository;
use Illuminate\Http\Response;
use App\Http\Resources\NoteResource;
use Log;

class NotesController extends Controller
{
    protected $notesRepository;

    public function __construct(NotesRepository $notesRepository)
    {
        $this->notesRepository = $notesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function listNotesRecently(Request $request)
    {
        $notes = $this->notesRepository->notesRecently($request->userID);
        Log::info('Showing for notes:', ['notes' => $notes]);
        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note = $this->notesRepository->create($request->all());
        return response()->json(new JsonResponse(new NoteResource($note)), Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = $this->notesRepository->showNote($id);
        return response()->json($note);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       $noteUpdate= $this->notesRepository->updateNote($request,$id);
       return response()->json($noteUpdate);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $this->notesRepository->destroy($id);
        return response()->json('delete success');
    }

    public function noteUserSelect(Request $request)
    {
        $listNoteUser = $this->notesRepository->showNoteSelect($request);
        return response()->json($listNoteUser);
    }
}
