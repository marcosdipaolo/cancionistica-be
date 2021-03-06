<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static where(string $key, string $value)
 */
class Payment extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];
}
