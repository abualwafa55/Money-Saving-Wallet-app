<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
    	'title', 'money', 'date', 'description',
    ];


    public function records()
    {
    	return $this->hasMany('App\Record');
    }
}
