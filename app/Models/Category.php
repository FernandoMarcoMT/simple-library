<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['name'];

    public function book_identity() : BelongsTo
    {
        return $this->belongsTo(\App\Models\BookIdentity::class);
    }
}
