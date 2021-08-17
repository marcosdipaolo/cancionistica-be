<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $path
 */
class Image extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
