<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Post extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(PostCategory::class);
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, "imageable");
    }
}
