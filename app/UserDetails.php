<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $fillable = ['address', 'province' , 'phone'];
    public function user(){

        return $this->belongsTo('App\User');
    }
}
