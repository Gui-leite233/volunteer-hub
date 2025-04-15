<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'location', 'date', 'capacity', 'category', 'user_id'];

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function registrations() {
        return $this->hasMany(Registration::class);
    }
}