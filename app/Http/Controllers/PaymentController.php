<?php

namespace App\Http\Controllers;

use App\Event;
use App\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class PaymentController extends Controller
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
        return view('payments.index')->with([
            'payments'=>Payment::orderby('updated_at','desc')->paginate(),
            'totals'=>DB::select(DB::raw('SELECT event_id, SUM(monto) as total FROM payments GROUP BY event_id'))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('payments.create')->with([
            'event'=>$event
        ]);
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
            'monto'=>'required|numeric'
        ]);
        if(auth()->user()->role->poder==3 || auth()->user()->role->poder==2){
            $event->payment()->create([
                'monto'=>$request->input('monto'),
                'fecha'=>Carbon::now()->format('Y-m-d'),
                'user_id'=>auth()->user()->id
            ]);
            return redirect()->route('events.index')->with([
                'message'=>'Abono creado al eventos '.$event->tipo,
                'code'=>'success'
            ]);
        }
        else{
            return redirect()->route('events.index')->with([
                'message'=>'No pudes aboner si no eres empleado o gerente, >:V',
                'code'=>'error'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
