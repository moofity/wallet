<?php

namespace App\Observers;

use App\Models\Transaction;
use InvalidArgumentException;

class TransactionObserver
{
    public function creating(Transaction $transaction)
    {
        $wallet = $transaction->wallet;
        $amount = $transaction->amount_with_sign;

        if ($wallet->balance + $amount < 0) {
            throw new InvalidArgumentException('Credit transaction amount cannot be less than wallet balance');
        }
    }

    /**
     * Handle the Transaction "created" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $wallet = $transaction->wallet;

        $wallet->balance = $wallet->balance + $transaction->amount_with_sign;
        $wallet->save();
    }

    /**
     * Handle the Transaction "updated" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "restored" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
