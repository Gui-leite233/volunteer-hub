<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model{
    protected $fillable = ['name', 'description', 'location', 'date', 'capacity', 'category', 'user_id'];

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_user_table', 'user_id', 'role_id')->withTimeStamps();
    }

    public function user(){
        return $this->belongstTo(User::class);
    }
}