<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">{{ $wallet->name }}</h5>
        <p class="card-text">{{ __('Wallet Balance: :balance', ['balance' => $wallet->formatted_balance]) }}</p>
        <div>
            <a href="{{ route('wallets.transactions.create', ['wallet' => $wallet->id]) }}" class="btn btn-primary btn-sm">{{ __('Create a Transaction 💰') }}</a>
            <a href="{{ route('wallets.show', ['wallet' => $wallet->id]) }}" class="btn btn-secondary btn-sm">{{ __('See details 📋') }}</a>
        </div>
    </div>
</div>