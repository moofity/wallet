<?php

namespace App\Services;

use App\Interfaces\Services\IWalletService;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use InvalidArgumentException;

/**
 * WalletService
 */
final class WalletService implements IWalletService
{
    /**
     * @inheritDoc
     */
    public function saveToUser(User $user, array $attributes): Wallet
    {
        $this->assertWalletRequiredFields($attributes);

        return $user->wallets()->create([
            'name' => $attributes['name'],
            'type' => $attributes['type']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function update(Wallet $wallet, array $attributes): Wallet
    {
        $this->assertWalletRequiredFields($attributes);

        $wallet->update([
            'name' => $attributes['name'],
            'type' => $attributes['type']
        ]);

        return $wallet->fresh();
    }

    /**
     * @inheritDoc
     */
    public function getUserWalletById(User $user, int $id): Wallet
    {
        return $user->wallets()->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function updateUserWalletById(User $user, int $walletId, array $attributes): Wallet
    {
        $wallet = $this->getUserWalletById($user, $walletId);
        $this->update($wallet, $attributes);

        return $wallet;
    }

    /**
     * @inheritDoc
     */
    public function addTransaction(
        Wallet $wallet,
        int $amount,
        string $transactionType
    ): Transaction {
        $this->assertTransactionRequiredFields($amount, $transactionType);

        $transaction = $wallet->transactions()->create([
            'amount' => $amount,
            'type' => $transactionType
        ]);

        return $transaction;
    }

    /** Utility service methods */
    protected function assertWalletRequiredFields(array $attributes)
    {
        $type = $attributes['type'] ?? null;

        if (!in_array($type, config('enum.wallet_types'))) {
            throw new InvalidArgumentException('Invalid `type` attribute provided for creating a wallet');
        }

        $name = $attributes['name'] ?? null;

        if (is_null($name)) {
            throw new InvalidArgumentException('Invalid `name` attribute provided for creating a wallet');
        }
    }

    protected function assertTransactionRequiredFields(int $amount, string $type)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Invalid `amount` attribute provided for create a transaction');
        }

        if (!in_array($type, config('enum.transaction_types'))) {
            throw new InvalidArgumentException('Invalid `type` attribute provided for creating a transaction');
        }
    }
}
