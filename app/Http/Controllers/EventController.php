<?php

namespace App\Http\Controllers;

use App\Event;
use App\Photo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use File;

class EventController extends Controller
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
        #role 1 cliente
        #role 2 cempleado
        #role 3 gerente
        if(auth()->user()->role->poder==1){
            $events= Event::where('cliente_id','=',auth()->user()->id)->orderBy('updated_at','desc')->paginate(3);
        }
        elseif(auth()->user()->role->poder==2){
            $events= Event::where('confirmado','=',true)->orderBy('updated_at','desc')->paginate(3);
        }
        elseif(auth()->user()->role->poder==3){
            $events= Event::where('gerente_id','=',auth()->user()->id)->orderBy('updated_at','desc')->paginate(3);
        }
        else{
            return redirect()->route('welcome')->with([
                'message'=>'No puedes hacer eso, te falta el permiso >:V',
                'code'=>'error'
            ]);
        }
        return view('events.index')->with([
            'events'=>$events
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'fecha'=>'date|required',
            'hora'=>'string|required',
            'tipo'=>'string|required',
        ]);
        if(auth()->user()->role->poder==1){
            Event::create([
                'fecha'=>$request->input('fecha'),
                'hora'=>$request->input('hora'),
                'tipo'=>$request->input('tipo'),
                'cliente_id'=>auth()->user()->id,
                'confirmado'=>false
            ]);
            return redirect()->route('events.index')->with([
                'message'=>'Se creo el evento',
                'code'=>'success'
            ]);
        }else{
            return redirect()->route('welcome')->with([
                'message'=>'No puedes crear un evento, no eres cliente >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        if(auth()->user()->role->poder==1){
            if(auth()->user()->id==$event->cliente_id){
                return view('events.show')->with([
                    'event'=>$event
                ]);
            }
            else{
                return redirect()->route('welcome')->with([
                    'message'=>'No es tuyo este evento >:V',
                    'code'=>'error'
                ]);
            }
        }
        elseif(auth()->user()->role->poder==2){
            if(auth()->user()->id==$event->empleado_id){
                return view('events.show')->with([
                    'event'=>$event
                ]);
            }
            else{
                return redirect()->route('welcome')->with([
                    'message'=>'No es tuyo este evento >:V',
                    'code'=>'error'
                ]);
            }
        }
        elseif(auth()->user()->role->poder==3){
            if(auth()->user()->id==$event->gerente_id){
                return view('events.show')->with([
                    'event'=>$event
                ]);
            }
            else{
                return redirect()->route('welcome')->with([
                    'message'=>'No es tuyo este evento >:V',
                    'code'=>'error'
                ]);
            }
        }
        else{
            return redirect()->route('welcome')->with([
                'message'=>'No puedes ver esto, no te pertenece >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        if(!$event->confirmado){
            return view('events.edit')->with(['event'=>$event]);
        }
        else{
            return redirect()->route('welcome')->with([
                'message'=>'Ya esta confirmado este evento, no lo puedo editar >:V',
                'code'=>'error'
            ]);
        }
    }
    public function photos(Request $request,Event $event)
    {
        $request->validate([
            'foto'=>'required|image|mimes:jpeg,jpg,png,gif'
        ]);
        if(auth()->user()->role->poder==2 || auth()->user()->role->poder==3){
            if($event->fecha <= Carbon::now()->format('Y-m-d')){
                $imageName = time().'.'.request()->file('foto')->getClientOriginalExtension();
                request()->file('foto')->move(public_path('images'), $imageName);
                $event->photo()->create([
                    'path'=>'/images'.'/'.$imageName,
                    'user_id'=>auth()->user()->id,
                ]);
                return redirect()->route('events.index')->with([
                    'message'=>'Se guardo la imagen',
                    'code'=>'success'
                ]);
            }
            else{
                return redirect()->route('events.index')->with([
                    'message'=>'No puedes subir una foto, porque el evento todavia no se hace >:V',
                    'code'=>'error'
                ]);
            }
        }
        else{
            $imageName = time().'.'.request()->file('foto')->getClientOriginalExtension();
            request()->file('foto')->move(public_path('images'), $imageName);
            $event->photo()->create([
                'path'=>'/images'.'/'.$imageName,
                'user_id'=>auth()->user()->id,
            ]);
            return redirect()->route('events.index')->with([
                'message'=>'Se guardo la imagen',
                'code'=>'success'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'fecha'=>'date',
            'hora'=>'string',
            'tipo'=>'string',
            'precio'=>'numeric',
        ]);
        if(auth()->user()->role->poder==1){
            $event->update($request->except(['precio','confirmado']));
            return redirect()->route('events.index')->with([
                'message'=>'Evento actualizado',
                'code'=>'success'
            ]);
        }elseif(auth()->user()->role->poder==3){
            $request['confirmado']=false;
            $request['gerente_id']=auth()->user()->id;
            $event->update($request->except(['fecha','hora','tipo']));
            return redirect()->route('events.index')->with([
                'message'=>'Se asigno el precio al evento',
                'code'=>'success'
            ]);
        }else{
            return redirect()->route('home')->with([
                'message'=>'No puedes realizar esta accion, >:V',
                'code'=>'error'
            ]);
        }
    }
    public function confirm(Event $event){
        if(!$event->confirmado){
            $event->update(['confirmado'=>true]);
            return redirect()->route('events.index')->with([
                'message'=>'Se confirmo el evento',
                'code'=>'success'
            ]);
        }
        else{
            return redirect()->route('events.index')->with([
                'message'=>'Ya se ha confirmado el evento, >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if($event->confirmado){
            return redirect()->route('events.index')->with([
                'message'=>'No se puedo hacer esto, ya esta confimado >:V',
                'code'=>'error'
            ]);
        }
        else{
            if(count($event->photo->all())>0){
                foreach($event->photo->all() as $photo){
                    File::delete(public_path().$photo->path);
                    $photo->delete();
                }
                $event->delete();
                return redirect()->route('events.index')->with([
                    'message'=>'Evento eliminado, junto con las fotos',
                    'code'=>'success'
                ]);
            }
            else{
                $event->delete();
                return redirect()->route('events.index')->with([
                    'message'=>'Evento eliminado',
                    'code'=>'success'
                ]);
            }
        }
    }
}
