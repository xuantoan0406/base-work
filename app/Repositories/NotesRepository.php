<?php

namespace App\Repositories;

use App\Models\Note;

class NotesRepository extends BaseRepository
{
    protected $model;


    public function __construct(Note $note)
    {
        $this->model = $note;
    }

    public function notesRecently($userID)
    {
        return $this->model->where('user_id', $userID)->orderBy('id', 'DESC')->limit(4)->get();
    }

    public function showNoteSelect($request)
    {
        $date=$request->daySelect;
        $timeClick = date("Y-m-d", strtotime($date));
        return $this->model->where('user_id', $request->userId)->where('updated_at', 'like', '%' . $timeClick . '%')->get();
    }
    public function updateNote($request,$id){
        $note = Note::find($id);
        $note->title= $request->title;
        $note->content= $request->content;
        $note->save();
        return $note;

    }

}
