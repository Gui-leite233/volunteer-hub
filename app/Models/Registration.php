<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Registration extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id', 'event_id', 'status_id', 'review'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }
    
    public function status() {
        return $this->belongsTo(Status::class, 'status_id');
    }
}