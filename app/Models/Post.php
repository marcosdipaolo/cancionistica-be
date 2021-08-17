<?php

namespace App\Models;

use App\Models\Contracts\Imageable;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Image $image
 */
class Post extends Model implements Imageable
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function postCategory(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, "imageable");
    }
}
