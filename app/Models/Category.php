<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    // Interested by users
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
