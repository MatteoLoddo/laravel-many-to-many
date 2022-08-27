<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\UserDetails;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        $users = User::all();
        $details = UserDetails::all();
        return view('admin.users.index', compact('users' , 'details') );
    }

    public function show($id){

        $user = User::findOrFail($id);

        return view('admin.users.show' , compact('user'));

    }


    public function edit($id){

        $user = User::findOrFail($id);
        $user->all();

        return view('admin.users.edit' , compact('user'));

    }


    public function update(Request $request , $id){

        $data = $request->all();

        $user = User::findOrFail($id);

        

        if(!$user->details){
            $user->details = new UserDetails();
            $user->details->user_id = $user->id;

            
        $user->details->fill($data);
        $user->details->save();
        }else{
            $user->details->update($data);
        }

        $user->update($data);

        
        return redirect()->route('admin.users.show' , compact('user') );
    }

    public function destroy($id){

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index' , compact('user'));
    }
}
