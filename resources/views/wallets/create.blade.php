@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form action="{{ route('wallets.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="walletName">{{ __('Wallet Name') }}</label>
                    <input value="{{ old('name') }}" name="name" type="text" class="form-control" id="walletName" aria-describedby="nameHelp" placeholder="{{ __('Enter Wallet name') }}" required>
                    <small id="nameHelp" class="form-text text-muted">{{ __('Choose a unique name for your Wallet') }}</small>
                </div>
                <div class="form-group">
                    <label for="walletType">{{ __('Wallet Type') }}</label>
                    <select name="type" class="custom-select" id="walletType" aria-label="Default select example" required>
                        <option value="" selected>{{ __('Choose Wallet type') }}</option>
                        @foreach (config('enum.wallet_types') as $walletType)
                        <option value="{{ $walletType }}" {{ old('type') == $walletType ? 'selected' : '' }}>{{ __('wallet.types.' . $walletType) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('Create Wallet') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection