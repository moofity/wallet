<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }

    public function getAmountWithSignAttribute(): int
    {
        if ($this->type === config('enum.transaction_types.credit')) {
            return -1 * $this->amount;
        }

        return $this->amount;
    }

    public function setAmountAttribute($value) {
        $this->attributes['amount'] = $value * config('constants.precision');
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount / config('constants.precision'), 2);
    }
}
