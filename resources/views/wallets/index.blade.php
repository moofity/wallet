@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Reporting') }}</div>
                <div class="card-body">
                    <div class="mb-4">
                        <p class="h3">
                            {{ __('All Wallets Total Balance: ') }} <b>{{ auth()->user()->total_balance }}</b>
                        </p>
                    </div>
                    <div>
                        <p class="h4">
                            {{ __('Latest Transactions') }}
                        </p>
                        @include('transactions.index', ['transactions' => auth()->user()->transactions])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header  d-flex justify-content-between align-items-center">
                    {{ __('My Wallets') }}
                    <a href="{{ route('wallets.create') }}" class="btn btn-sm btn-primary">{{ __('Create a Wallet 💳') }}</a>
                </div>
                <div class="card-body">
                    @each('wallets.list-item', $wallets, 'wallet', 'wallets.list-item-empty')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection