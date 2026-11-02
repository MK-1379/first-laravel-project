<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_name', 'event_detail',
    ];
    public function users(){
        return $this->belongsToMany('App\Models\User')->withTimestamps();
}
}

