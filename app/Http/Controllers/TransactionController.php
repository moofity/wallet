<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Interfaces\Services\IWalletService;
use App\Models\Wallet;
use InvalidArgumentException;

class TransactionController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct(protected IWalletService $walletService)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Wallet $wallet)
    {
        return view('transactions.create', ['wallet' => $wallet]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateTransactionRequest  $request
     * @param  Wallet $wallet
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request, Wallet $wallet)
    {
        try {
            $this->walletService->addTransaction($wallet, $request->amount, $request->type);
            return redirect(route('wallets.show', ['wallet' => $wallet]));
        } catch (InvalidArgumentException $exception) {
            return redirect()->back()->with('flash_warning', $exception->getMessage());
        }
    }
}
