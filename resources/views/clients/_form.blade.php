@props(['client' => null, 'statuses', 'managers', 'route', 'method' => 'POST'])

<form method="POST" action="{{ $route }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @if($method !== 'POST') @method($method) @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Name --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                {{ __('messages.client_name') }} <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name', $client?->name) }}" required
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
            @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_email') }}</label>
            <input type="email" name="email" value="{{ old('email', $client?->email) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Phone --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_phone') }}</label>
            <input type="text" name="phone" value="{{ old('phone', $client?->phone) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Company --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_company') }}</label>
            <input type="text" name="company" value="{{ old('company', $client?->company) }}"
                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_status') }}</label>
            <select name="client_status_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">—</option>
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" @selected(old('client_status_id', $client?->client_status_id) == $status->id)>{{ $status->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Manager (head/admin only) --}}
        @if(auth()->user()->isAdmin() || auth()->user()->isHead())
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_manager') }}</label>
            <select name="manager_id"
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">—</option>
                @foreach($managers as $manager)
                    <option value="{{ $manager->id }}" @selected(old('manager_id', $client?->manager_id) == $manager->id)>{{ $manager->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        {{-- Avatar --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_avatar') }}</label>
            <div class="flex items-center gap-4"
                 x-data="{
                     preview: '{{ $client?->avatar ? asset('storage/'.$client->avatar) : '' }}',
                     handleFile(e) {
                         const file = e.target.files[0];
                         if (file) { this.preview = URL.createObjectURL(file); }
                     }
                 }">
                <div class="flex-shrink-0">
                    <img x-show="preview" :src="preview"
                         class="w-16 h-16 rounded-xl object-cover border border-gray-200 dark:border-gray-600">
                    <img x-show="!preview" src="{{ asset('images/no_image_icon.svg') }}"
                         class="w-16 h-16 rounded-xl opacity-40">
                </div>
                <label class="cursor-pointer flex items-center gap-2 px-4 py-2 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-400 transition text-sm text-gray-500 dark:text-gray-400">
                    <x-icon name="arrow-up-tray" class="w-4 h-4" />
                    <span>{{ __('messages.client_avatar') }}</span>
                    <input type="file" name="avatar" accept="image/*" class="sr-only" @change="handleFile($event)">
                </label>
                @if($client?->avatar)
                <label class="flex items-center gap-1.5 text-xs text-red-500 cursor-pointer">
                    <input type="checkbox" name="remove_avatar" value="1" class="rounded">
                    {{ __('messages.delete') }}
                </label>
                @endif
            </div>
            @error('avatar') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Comment --}}
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">{{ __('messages.client_comment') }}</label>
            <textarea name="comment" rows="3"
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('comment', $client?->comment) }}</textarea>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition">
            {{ __('messages.save') }}
        </button>
        <a href="{{ route('clients.index') }}"
           class="px-5 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition">
            {{ __('messages.cancel') }}
        </a>
    </div>
</form>
