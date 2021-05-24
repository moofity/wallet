<table class="table table-sm table-hover mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{ __('Type') }}</th>
      <th scope="col">{{ __('Amount') }}</th>
      <th scope="col">{{ __('Date') }}</th>
    </tr>
  </thead>
  <tbody>
    @each('transactions.list-item', $transactions, 'transaction', 'transactions.list-item-empty')
  </tbody>
</table>