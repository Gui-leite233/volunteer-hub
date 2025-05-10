<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'event_date',
        'location_name',
        'latitude',
        'longitude',
        'capacity',
        'category',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function confirmedRegistrationsCount()
    {
        return $this->registrations()->where('status', 'confirmed')->count();
    }

    public function isAtCapacity()
    {
        return $this->confirmedRegistrationsCount() >= $this->capacity;
    }
}
