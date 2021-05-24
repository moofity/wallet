<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'balance'
    ];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'wallet_id')->latest();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedBalanceAttribute(): string
    {
        return number_format($this->balance / config('constants.precision'), 2);
    }
}
