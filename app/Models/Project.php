<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function pickup(){
        return $this->hasOne(Pickup::class);
    }

    public function isPickup(){
        return $this->pickup()->where('project_id', $this->id)->exists();
    }
}
