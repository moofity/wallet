@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('wallets.transactions.store', ['wallet' => $wallet->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="walletName">{{ __('Transaction amount') }}</label>
                    <input value="{{ old('amount') }}" name="amount" type="number" class="form-control" id="transacrtionAmount" placeholder="{{ __('Enter Transaction amount') }}" required>
                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="typeCredit" value="{{ config('enum.transaction_types.credit') }}" checked>
                        <label class="form-check-label" for="typeCredit">
                            {{ __('transaction.types.' . config('enum.transaction_types.credit')) }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="typeDebit" value="{{ config('enum.transaction_types.debit') }}">
                        <label class="form-check-label" for="typeDebit">
                            {{ __('transaction.types.' . config('enum.transaction_types.debit')) }}
                        </label>
                    </div>
                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">{{ __('Create Transaction') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection