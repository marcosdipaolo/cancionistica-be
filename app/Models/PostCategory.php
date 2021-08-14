<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostCategory extends Model
{
    use HasFactory, UuidTrait;

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
