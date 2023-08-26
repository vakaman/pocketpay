<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <form class="rounded" method="POST" action="{{ route('pocket-manager.wallet.create') }}">

                    @csrf

                    <input type="hidden" name="person" value="{{ session()->all()['person']->id->value }}">
                    <input type="hidden" name="type" value="{{ session()->all()['person']->type->id }}">

                    <div class="flex items-center justify-between">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            {{ __('Create Wallet') }}
                        </button>

                    </div>
                </form>

            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 z">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg flex flex-col justify-center items-center">

                @if (!empty($wallets))
                    <x-tables.wallets-list :wallets="$wallets"></x-tables.wallets-list>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

<x-alerts.success></x-alerts.success>
<x-alerts.error></x-alerts.error>
