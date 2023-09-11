<table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">{{ __('Status') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('From') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('To') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('Value') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('Date') }}</th>
        </tr>
    </thead>

    <tbody>
        @if (!empty($transactions->values))
            @foreach ($transactions->values as $transaction)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 group/item hover:bg-slate-950">

                    <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $transaction->status->name }}
                    </td>

                    <td class="px-6 py-4">{{ $transaction->from->value }}</td>
                    <td class="px-6 py-4">{{ $transaction->to->value }}</td>
                    <td class="px-6 py-4">{{ $transaction->value->toReal() }}</td>
                    <td class="px-6 py-4">{{ $transaction->createdAt->format('d/m/Y H:i') }}</td>

                </tr>
            @endforeach
        @else
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 group/item hover:bg-slate-950">
                <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
                <td class="px-6 py-4"></td>
            </tr>
        @endif
    </tbody>
</table>
