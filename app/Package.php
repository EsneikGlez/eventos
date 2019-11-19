<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable=['descripcion','activo','precio'];
    public function event(){
        return $this->hasOne('App\Event');
    }
}
