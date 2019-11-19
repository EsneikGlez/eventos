<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=['fecha','hora','tipo','precio','cliente_id','gerente_id','package_id','confirmado'];
    public function gerente(){
        return $this->belongsTo('App\User','gerente_id');
    }
    public function cliente(){
        return $this->belongsTo('App\User','cliente_id');
    }
    public function package(){
        return $this->belongsTo('App\Package');
    }
    public function payment(){
        return $this->hasMany('App\Payment');
    }
    public function photo(){
        return $this->hasMany('App\Photo');
    }
}
