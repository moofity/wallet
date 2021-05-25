<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWalletRequest;
use App\Http\Requests\UpdateWalletRequest;
use App\Interfaces\Services\IWalletService;
use App\Models\Wallet;
use Throwable;

class WalletController extends Controller
{
    public function __construct(private IWalletService $walletService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if session flag is set redirect to create page
        if (session('verified')) {
            return redirect()->route('wallets.create')->with('flash_message', __('Let\'s create your first Wallet.'));
        }

        // otherwise get all wallets
        $wallets = auth()->user()->wallets;
        return view('wallets.index', compact('wallets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('wallets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateWalletRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateWalletRequest $request)
    {
        $wallet = $this->walletService->saveToUser(auth()->user(), $request->validated());

        return redirect()->route('wallets.show', ['wallet' => $wallet->id])->with('flash_success', 'Successfully created a Wallet.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $wallet = $this->walletService->getUserWalletById(auth()->user(), $id);

        return view('wallets.details', ['wallet' => $wallet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return redirect()->route('wallets.show', ['wallet' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWalletRequest $request, int $id)
    {
        $wallet = $this->walletService->updateUserWalletById(auth()->user(), $id, $request->validated());
        return redirect()->route('wallets.show', ['wallet' => $wallet->id])->with('flash_success', __('Successfully updated wallet.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
