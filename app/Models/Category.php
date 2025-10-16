<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function story()
    {
        return $this->hasMany(Story::class);
    }
}
