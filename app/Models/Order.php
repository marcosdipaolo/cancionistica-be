<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = [];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPayment()
    {
        return Payment::where("preference_id", $this->preference_id)->first();
    }

    /**
     * Only for maintenance
     * @return int
     */
    public static function clearPaymentlessOrders(): int {
        $count = 0;
        static::all()->each(function(self $order) use (&$count) {
            if (!$order->getPayment()) {
                $count++;
                $order->delete();
            }
        });
        return $count;
    }
}
