<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable=['fecha','monto','event_id','user_id',];
    public function event(){
        return $this->belongsTo('App\Event');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
