<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = [
    	'title', 'money', 'date', 'description', 'goal_id',
    ];
}
