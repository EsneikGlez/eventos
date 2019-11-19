<?php

namespace App\Http\Controllers;

use App\Event;
use App\Photo;
use Illuminate\Http\Request;
use File;

class PhotoController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Event $event)
    {
        $request->validate([
            'image'=>'required|image|mimes:jpeg,jpg,png,gif'
        ]);
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
        switch(auth()->user()->role->poder){
            case 1:
                $event->photo->create([
                    'path'=>'/images'.'/'.$imageName,
                    'event_id'=>$event->id,
                    'cliente_id'=>auth()->user()->id
                ]);
                break;
            case 2:
                $event->photo->create([
                    'path'=>'/images'.'/'.$imageName,
                    'event_id'=>$event->id,
                    'empleado_id'=>auth()->user()->id
                ]);
                break;
            case 3:
                $event->photo->create([
                    'path'=>'/images'.'/'.$imageName,
                    'event_id'=>$event->id,
                    'gerente_id'=>auth()->user()->id
                ]);
                break;
            default:
                return redirect()->route('events.index')->with([
                    'message'=>'Tu no puede hacer eso, >:V',
                    'code'=>'success'
                ]);
                break;
        }
        return redirect()->route('events.index')->with([
            'message'=>'Se guardo la imagen',
            'code'=>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        if(auth()->user()->role->poder==3){
            if($photo->user->role->poder==2  || auth()->user()->id==$photo->user_id){
                File::delete(public_path().$photo->path);
                $photo->delete();
                return redirect()->route('events.index')->with([
                    'message'=>'Foto eliminada',
                    'code'=>'success'
                ]);
            }
            else{
                return redirect()->route('events.index')->with([
                    'message'=>'No puedes eliminar la foto, le pertenece a un usuario >:V',
                    'code'=>'error'
                ]);
            }
        }
        else{
            if(auth()->user()->id==$photo->user_id){
                File::delete(public_path().$photo->path);
                $photo->delete();
                return redirect()->route('events.index')->with([
                    'message'=>'Foto eliminada',
                    'code'=>'success'
                ]);
            }
            else{
                return redirect()->route('events.index')->with([
                    'message'=>'No puedes eliminar la foto, no es tuya >:V',
                    'code'=>'error'
                ]);
            }
        }

    }
}
