<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressNote extends Model
{
    public function project(){
        return $this->belongsTo(ProgressNote::class);
    }
}
