<?php

namespace App\Repositories;

use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class StatusRepository extends BaseRepository
{
    protected $model;


    public function __construct(Status $status)
    {
        $this->model = $status;
    }

    public function paginated($paginate)
    {
        return $this
            ->model
            ->where('domain_id', Auth::user()->domain_id)
            ->where('type',0)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate($paginate);
    }

    public function domain($id){
        return $this->model->where('domain_id', $id)->where('type',0)->paginate(8);
    }
    public function statusMaster(){
        return $this
            ->model
            ->where('domain_id', Auth::user()->domain_id)
            ->where('type',1)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate(5);
    }

}
