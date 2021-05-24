<?php

namespace Tests\Unit;

use App\Interfaces\Services\IWalletService;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use InvalidArgumentException;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{

    protected IWalletService $walletService;

    public function setUp(): void
    {
        parent::setUp();
        $this->walletService = $this->app->make('App\Interfaces\Services\IWalletService');
    }

    public function test_walletFactory() {
        $wallet = Wallet::factory()->create();
        $this->assertDatabaseHas('wallets', [
            'name' => $wallet->name,
            'type' => $wallet->type,
            'balance' => 0
        ]);
    }

    /**
     * Test valid input.
     *
     * @return void
     */
    public function test_saveWalletToUser()
    {
        collect($this->getValidWalletAttributes())->each(function ($item) {
            $user = User::factory()->create();
            $wallet = $this->walletService->saveToUser($user, $item);

            $this->assertTrue($user->wallets->last()->is($wallet));
            $this->assertDatabaseHas('wallets', array_merge($item, ['balance' => 0]));
        });
    }

    /**
     * Test invalid input.
     *
     * @return void
     */
    public function test_saveWalletToUserWithInvalidAttributes()
    {
        collect($this->getInvalidWalletAttributes())->each(function ($item) {
            $user = User::factory()->create();

            $this->expectException(InvalidArgumentException::class);
            $this->walletService->saveToUser($user, $item);

            $this->assertEmpty($user->wallets);
            $this->assertDatabaseMissing('wallets', $item);
        });
    }

    /**
     * Test valid input.
     *
     * @return void
     */
    public function test_updateWallet()
    {
        $wallet = Wallet::factory()->create();

        $attributes = $this->getValidWalletAttributes()[0];

        $updatedWallet = $this->walletService->update($wallet, $attributes);

        $this->assertSame($updatedWallet->name, $attributes['name']);
        $this->assertSame($updatedWallet->type, $attributes['type']);
        $this->assertTrue($updatedWallet->is($wallet));
    }

    /**
     * Test invalid input.
     *
     * @return void
     */
    public function test_updateWalletWithInvalidAttributes()
    {
        $wallet = Wallet::factory()->create();

        collect($this->getInvalidWalletAttributes())->each(function ($attributes) use ($wallet) {

            $this->expectException(InvalidArgumentException::class);
            $updatedWallet = $this->walletService->update($wallet, $attributes);

            $this->assertNotSame($updatedWallet->name, $attributes['name']);
            $this->assertNotSame($updatedWallet->type, $attributes['type']);
            $this->assertTrue($updatedWallet->is($wallet));
        });
    }

    /**
     * 
     */
    public function test_getUserWalletById()
    {
        $wallet = Wallet::factory()->create();

        $foundWallet = $this->walletService->getUserWalletById($wallet->user, $wallet->id);

        $this->assertTrue($foundWallet->is($wallet));

        $this->expectException(ModelNotFoundException::class);
        $foundWallet = $this->walletService->getUserWalletById($wallet->user, 666);
    }

    public function test_addTransaction()
    {
        $wallet = Wallet::factory()->create();

        collect($this->getValidTransactionAttributes())->each(function ($item) use ($wallet) {
            $transaction = $this->walletService->addTransaction($wallet, $item['amount'], $item['type']);
            $wallet->refresh();
            $this->assertTrue($wallet->transactions->last()->is($transaction));

            $this->assertDatabaseHas('transactions', [
                'amount' => $item['amount'] * config('constants.precision'),
                'type' => $item['type']
            ]);

            $this->assertEquals($wallet->balance, $item['totalBalance']);
        });
    }

    public function test_addTransactionWithInvalidAttributes()
    {
        $wallet = Wallet::factory()->create();

        $this->expectException(InvalidArgumentException::class);
        $this->walletService->addTransaction($wallet, -1000, config('enum.transaction_types.credit'));
        $this->assertTrue($wallet->is($wallet->fresh()));

        $this->expectException(InvalidArgumentException::class);
        $this->walletService->addTransaction($wallet, 1000, config('enum.transaction_types.credit'));
        $this->assertTrue($wallet->is($wallet->fresh()));

        $wallet = Wallet::factory()->positiveBalance()->create();
        $largeCreditTransaction = -1 * $wallet->balance * 100;

        $this->expectException(InvalidArgumentException::class);
        $this->walletService->addTransaction($wallet, $largeCreditTransaction, config('enum.transaction_types.credit'));
        $this->assertTrue($wallet->is($wallet->fresh()));
    }

    /**
     * @return array
     */
    protected function getValidWalletAttributes()
    {
        return [
            [
                'name' => 'My Awesome Cash Wallet',
                'type' => config('enum.wallet_types.cash')
            ],
            [
                'name' => 'My Awesome Credit Card Wallet',
                'type' => config('enum.wallet_types.credit_card')
            ]
        ];
    }

    /**
     * @return array
     */
    protected function getInvalidWalletAttributes()
    {
        return [
            [
                'name' => null, // invalid name
                'type' => config('enum.wallet_types.cash') // valid type
            ],
            [
                'name' => 'My Awesome Cash Wallet', // valid name
                'type' => 'Some Random Type' // invalid type
            ]
        ];
    }

    protected function getValidTransactionAttributes()
    {
        return [
            [
                'amount' => 10,
                'type' => config('enum.transaction_types.debit'),
                'totalBalance' => 10 * config('constants.precision')
            ],
            [
                'amount' => 10,
                'type' => config('enum.transaction_types.credit'),
                'totalBalance' => 0
            ],
            [
                'amount' => 250,
                'type' => config('enum.transaction_types.debit'),
                'totalBalance' => 250 * config('constants.precision')
            ],
            [
                'amount' => 150,
                'type' => config('enum.transaction_types.credit'),
                'totalBalance' => 100 * config('constants.precision')
            ],
        ];
    }
}
