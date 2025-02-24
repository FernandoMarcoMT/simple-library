<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookIdentity extends Model
{
    protected $guarded = ['id'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Book::class);
    }

    public function category(): HasMany
    {
        return $this->hasMany(\App\Models\Category::class);
    }

    public function author(): HasMany
    {
        return $this->hasMany(\App\Models\Author::class);
    }

    public function publisher(): HasMany
    {
        return $this->hasMany(\App\Models\Publisher::class);
    }
}
