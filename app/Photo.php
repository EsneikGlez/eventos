<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable=['path','event_id','user_id'];
    public function event(){
        return $this->belongsTo('App\Event');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
