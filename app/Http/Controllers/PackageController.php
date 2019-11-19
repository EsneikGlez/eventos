<?php

namespace App\Http\Controllers;

use App\Event;
use App\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
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
        return view('packages.index')->with([
            'packages'=>Package::orderBy('updated_at','desc')->paginate()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('packages.create')->with([
            'events'=>Event::all()
        ]);
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
            'descripcion'=>'string|required',
            'precio'=>'numeric|required',
            'event_id'=>'numeric|required'
        ]);
        $request['activo']=false;
        $package=Package::create($request->except('event_id'));
        $event=Event::findOrFail($request->input('event_id'));
        $event->update(['package_id'=>$package->id]);
        return redirect()->route('packages.index')->with([
            'message'=>'Paquete creado',
            'code'=>'success'
        ]);
    }
    public function toggle(Package $package){
        $package->update([
            'activo'=>!$package->activo
        ]);
        return redirect()->route('packages.index')->with([
            'message'=>'Paquete modificado',
            'code'=>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        return view('packages.edit')->with([
            'package'=>$package
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'descripcion'=>'string',
            'precio'=>'numeric',
        ]);
        $package->update($request->all());
        return redirect()->route('packages.index')->with([
            'message'=>'Paquete modificado',
            'code'=>'success'
        ]);
    }

}
