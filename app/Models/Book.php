<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\User::class);
    }

    public function book_identity(): HasMany
    {
        return $this->hasMany(\App\Models\BookIdentity::class);
    }

}
