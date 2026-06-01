@props(['deal' => null, 'statuses', 'clients', 'selected' => null, 'route', 'method' => 'POST'])

<form method="POST" action="{{ $route }}" class="space-y-5">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Title --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                {{ __('messages.deal_title') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title', $deal?->title) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-400 @enderror">
            @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Client --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                {{ __('messages.deal_client') }} <span class="text-red-500">*</span>
            </label>
            <select name="client_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('client_id') border-red-400 @enderror">
                <option value="">—</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" @selected(old('client_id', $deal?->client_id ?? $selected) == $client->id)>{{ $client->name }}</option>
                @endforeach
            </select>
            @error('client_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.deal_status') }}</label>
            <select name="deal_status_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">—</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @selected(old('deal_status_id', $deal?->deal_status_id) == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Amount --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.deal_amount') }}</label>
            <input type="number" name="amount" value="{{ old('amount', $deal?->amount) }}" min="0" step="0.01"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Comment --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.deal_comment') }}</label>
            <textarea name="comment" rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('comment', $deal?->comment) }}</textarea>
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            {{ __('messages.save') }}
        </button>
        <a href="{{ route('deals.index') }}"
           class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition">
            {{ __('messages.cancel') }}
        </a>
    </div>
</form>
