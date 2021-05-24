<?php

namespace App\Interfaces\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

interface IWalletService
{    
    /**
     * saveToUser
     *
     * @param  User $user
     * @param  array $attributes
     * @return Wallet
     */
    function saveToUser(User $user, array $attributes): Wallet;
        
    /**
     * update
     *
     * @param  Wallet $wallet
     * @param  array $attributes
     * @return Wallet
     */
    function update(Wallet $wallet, array $attributes): Wallet;

    /**
     * @throws ModelNotFoundException
     */
    function getUserWalletById(User $user, int $id): Wallet;
        
    /**
     * updateUserWalletById
     *
     * @param  User $user
     * @param  int $walletId
     * @param  array $attributes
     * @return Wallet
     */
    function updateUserWalletById(User $user, int $walletId, array $attributes): Wallet;
    
    /**
     * addTransaction
     *
     * @param  Wallet $wallet
     * @param  int $amount
     * @param  string $transactionType
     * @return Transaction
     */
    function addTransaction(Wallet $wallet, int $amount, string $transactionType): Transaction;
}
