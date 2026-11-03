<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = ['description'];

    // Un tipo de evento tiene muchos eventos (1:N)
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
