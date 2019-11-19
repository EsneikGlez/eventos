<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index')->with([
            'users'=>User::paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function password(Request $request,User $user)
    {
        if(auth()->user()->role->poder==3 || auth()->user()->id==$user->id){
            $user->update([
                'password'=>Hash::make($request->input('password'))
            ]);
            auth()->user()->id==$user->id?Auth::logout():'0';
            return redirect()->route('users.index')->with([
                'message'=>'Se actualizo contraseña',
                'code'=>'success'
            ]);
        }
        else{
            return redirect()->route('users.index')->with([
                'message'=>'No tienes permisos para haces esto >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit')->with([
            'user'=>$user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,User $user)
    {
        $request->validate([
            'email'=>'string|max:255|unique:users,email,id'.$user->id,
            'name'=>'string|max:255'
        ]);
        if(auth()->user()->role->poder==3){
            $user->update($request->all());
            return redirect()->route('users.index')->with([
                'message'=>'Se actualizo al usuario',
                'code'=>'success'
            ]);
        }
        else{
            return redirect()->route('users.index')->with([
                'message'=>'No tienes permisos para haces esto >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(auth()->user()->role->poder==3){
            $user->delete();
            return redirect()->route('users.index')->with([
                'message'=>'Se elimino al usuario',
                'code'=>'success'
            ]);
        }
        else{
            return redirect()->route('users.index')->with([
                'message'=>'No tienes permisos para haces esto >:V',
                'code'=>'error'
            ]);
        }
    }
}
