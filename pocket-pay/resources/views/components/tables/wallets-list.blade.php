<table class="table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            {{-- <th scope="col" class="px-6 py-3">ID</th> --}}
            <th scope="col" class="px-6 py-3">{{ __('Funds') }}</th>
            <th scope="col" class="px-6 py-3">{{ __('Main') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($wallets as $wallet)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 group/item hover:bg-slate-950">
                {{-- <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $wallet->id->value }}
                </td> --}}
                <td class="px-6 py-4">{{ $wallet->money->toReal() }}</td>
                <td class="px-6 py-4">
                    @if ($wallet->main === true)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    @endif


                    @if ($wallet->main === false && $wallet->money->toInt() === 0)
                        <form method="POST" action="{{ route('pocket-manager.wallet.delete') }}">

                            @csrf

                            <input type="hidden" name="wallet" value="{{ $wallet->id->value }}">

                            <button
                                class=" transition-opacity duration-300 ease-in-out
                                        group/edit invisible group-hover/item:visible
                                        items-center bg-red-500 border border-transparent
                                        rounded-md text-xs text-white active:bg-red-700 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    @endif


                </td>
            </tr>
        @endforeach
    </tbody>
</table>
