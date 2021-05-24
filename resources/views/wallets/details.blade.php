@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <p class="h2">
                {{ __('Total balance: :balance', ['balance' => $wallet->formatted_balance]) }}
            </p>
            <a href="{{ route('wallets.transactions.create', ['wallet' => $wallet->id]) }}" class="btn btn-primary">
                {{ __('Add a transaction') }}
            </a>
        </div>
    </div>
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <form action="{{ route('wallets.update', ['wallet' => $wallet->id]) }}" method="POST">
                @method('put')
                @csrf
                <!-- {!! method_field('PUT') !!} -->
                <div class="form-group">
                    <label for="walletName">{{ __('Wallet Name') }}</label>
                    <input value="{{ $wallet->name }}" name="name" type="text" class="form-control" id="walletName" placeholder="{{ __('Enter Wallet name') }}" required>
                </div>
                <div class="form-group">
                    <label for="walletType">{{ __('Wallet Type') }}</label>
                    <select name="type" class="custom-select" id="walletType" aria-label="Default select example" required>
                        @foreach (config('enum.wallet_types') as $walletType)
                            <option value="{{ $walletType }}" {{ $wallet->type === $walletType ? 'selected' : '' }}>{{ __('wallet.types.' . $walletType) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Update Wallet') }}</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
           @include('transactions.index', ['transactions' => $wallet->transactions])
        </div>
    </div>
</div>
@endsection