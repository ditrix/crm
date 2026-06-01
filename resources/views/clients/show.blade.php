<x-layout>
    <x-slot name="heading">{{ $client->name }}</x-slot>

    @if(session('success'))
        <x-alert class="mb-4">{{ session('success') }}</x-alert>
    @endif

    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('clients.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition">
            <x-icon name="chevron-left" class="w-4 h-4" />
            {{ __('messages.clients') }}
        </a>

        @can('update', $client)
        <a href="{{ route('clients.edit', $client) }}"
           class="ml-auto inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            <x-icon name="pencil" class="w-4 h-4" />
            {{ __('messages.edit') }}
        </a>
        @endcan
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        {{-- Info card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 space-y-4">
            {{-- Avatar --}}
            <div class="flex items-center gap-4">
                @if($client->avatar)
                    <img src="{{ asset('storage/'.$client->avatar) }}" class="w-16 h-16 rounded-2xl object-cover">
                @else
                    <div class="w-16 h-16 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                        <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ strtoupper(substr($client->name, 0, 1)) }}</span>
                    </div>
                @endif
                <div>
                    <h2 class="font-semibold text-lg text-gray-900 dark:text-white">{{ $client->name }}</h2>
                    @if($client->company)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $client->company }}</p>
                    @endif
                    <x-status-badge :slug="$client->status?->slug" :name="$client->status?->name" />
                </div>
            </div>

            <div class="space-y-2 text-sm">
                @if($client->email)
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="font-medium min-w-20">Email:</span>
                    <a href="mailto:{{ $client->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $client->email }}</a>
                </div>
                @endif
                @if($client->phone)
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="font-medium min-w-20">{{ __('messages.client_phone') }}:</span>
                    <a href="tel:{{ $client->phone }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">{{ $client->phone }}</a>
                </div>
                @endif
                @if($client->manager)
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="font-medium min-w-20">{{ __('messages.client_manager') }}:</span>
                    <span>{{ $client->manager->name }}</span>
                </div>
                @endif
            </div>

            @if($client->comment)
            <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <p class="text-xs font-medium text-gray-400 dark:text-gray-500 mb-1">{{ __('messages.client_comment') }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $client->comment }}</p>
            </div>
            @endif

            <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                <x-updated-by :user="$client->updatedBy" :date="$client->updated_at" />
            </div>
        </div>

        {{-- Deals --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-medium text-gray-900 dark:text-white">{{ __('messages.deals') }}</h3>
                    @can('create', \App\Models\Deal::class)
                    <a href="{{ route('deals.create', ['client_id' => $client->id]) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition">
                        <x-icon name="plus" class="w-3.5 h-3.5" />
                        {{ __('messages.add_deal') }}
                    </a>
                    @endcan
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-700 text-left">
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.deal_title') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.deal_status') }}</th>
                            <th class="px-4 py-3 font-medium text-gray-500 dark:text-gray-400">{{ __('messages.deal_amount') }}</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-700/50">
                        @forelse($client->deals as $deal)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $deal->title }}</td>
                            <td class="px-4 py-3"><x-status-badge :slug="$deal->status?->slug" :name="$deal->status?->name" /></td>
                            <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                {{ $deal->amount ? number_format($deal->amount, 0, '.', ' ') : '—' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('deals.show', $deal) }}"
                                   class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition inline-flex">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">{{ __('messages.no_data') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Files --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-5">
                <h3 class="font-medium text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="paper-clip" class="w-4 h-4 text-gray-400" />
                    {{ __('messages.files') }}
                </h3>
                <x-file-uploader fileable-type="client" :fileable-id="$client->id" :files="$client->files" />
            </div>
        </div>
    </div>
</x-layout>
