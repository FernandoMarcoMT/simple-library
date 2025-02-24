<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Author extends Model
{
    protected $guarded = ['id'];

    public function book_identity() : BelongsTo
    {
        return $this->belongsTo(\App\Models\BookIdentity::class);
    }
}
