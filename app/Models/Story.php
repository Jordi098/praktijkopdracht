<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use HasFactory;
    use SoftDeletes;

    // ensure published is treated as boolean
    protected $casts = [
        'published' => 'boolean',
    ];

    // optional default value (migrations also set default)
    protected $attributes = [
        'published' => true,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
