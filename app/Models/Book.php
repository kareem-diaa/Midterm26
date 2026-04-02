<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    /**
     * Security Constraint: Explicit $fillable to prevent mass assignment on protected fields.
     */
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'copies',
    ];

    public function borrows(): HasMany
    {
        return $this->hasMany(Borrow::class);
    }
}
