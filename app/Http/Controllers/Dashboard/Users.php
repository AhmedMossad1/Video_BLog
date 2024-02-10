<?php
namespace App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\BackEnd\Users\Store;
use App\Http\Requests\BackEnd\Users\Update;
use App\Models\User;
class Users extends DashboardController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function store(Store $requset){
        $requestArray = $requset->all();
        User::create($requestArray);
        $requestArray['password'] =  Hash::make($requestArray['password']);

        return redirect()->route('users.index');
    }
    public function update($id,Update $request){
        $row=User::findOrfail($id);
        $requestarray= [
            'name' => $request->name,
            'email' => $request->email
        ];
        $row->update($requestarray);
        //return redirect()->route('users.edit',['id'=>$row->id]);
        return redirect()->route('users.index');
    }


}
