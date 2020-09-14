<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function paginated($paginate)
    {
        return $this
            ->model
            ->where('domain_id', Auth::user()->domain_id)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->paginate($paginate);
    }

    public function orderByName($paginate)
    {
        return $this
            ->model
            ->where('domain_id', Auth::user()->domain_id)
            ->orderBy('name', 'ASC')
            ->paginate($paginate);
    }

    public function all()
    {
        return $this->model
            ->where('domain_id', Auth::user()->domain_id)
            ->orderBy($this->sortBy, $this->sortOrder)
            ->get();
    }

    public function updateInformation(Request $request)
    {

        $information = User::find($request->id);
        if ($request->avatar  )  {
            $avatar = $request->avatar->getClientOriginalName();
            $request->avatar->move(public_path('imgs/avatarUser'), $avatar);
            $information->avatar = $avatar;
        }

        $information->name = $request->name;
        $information->work_place = $request->work_place;
        $information->industry = $request->industry;
        $information->comment = $request->comment;
        $information->save();
        return $information;


    }
    public function showUser($id){
       return $user=User::find($id);

    }

}
