<?php

namespace App\Models;

use App\Models\Contracts\Imageable;
use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Course extends Model implements Imageable
{
    use HasFactory, UuidTrait;

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, "imageable");
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }
}
