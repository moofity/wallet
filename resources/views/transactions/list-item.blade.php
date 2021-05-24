<tr>
    <td>{{ $transaction->id }}</td>
    <td>{{ __('transaction.types.' . $transaction->type) }}</td>
    <td>{{ $transaction->formatted_amount }}</td>
    <td>{{ $transaction->created_at->format('F j, Y H:i T') }}</td>
</tr>