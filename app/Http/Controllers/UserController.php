<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();

        return view('user.index',["users" => $users]);
    }

    public function add(){
        return view('user.add');
    }

    public function processAdd(Request $request){
        $user = new User();
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->save();

        return redirect('/');
    }

    public function edit($id){
        $user = User::find($id);

        return view('user.edit',["user" => $user]);
    }

    public function processEdit(Request $request){
        $user = User::find($request->input('id'));
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->save();

        return redirect('/');
    }

    public function delete($id){
        $user = User::find($id);
        $user->delete();

        return redirect('/');
    }
}
