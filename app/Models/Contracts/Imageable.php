<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

/**
 * @property Collection images
 */
interface Imageable
{
    public function images(): MorphMany;
}
