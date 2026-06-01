<x-layout>
    <x-slot name="heading">{{ __('messages.notes') }}</x-slot>

    <div class="max-w-2xl"
         x-data="notepad('{{ route('tools.note.update') }}', '{{ csrf_token() }}')"
         @keydown.window.debounce.1500ms="save">

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden">
            {{-- Status bar --}}
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-700">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.notes') }}</span>
                <span x-text="status" class="text-xs text-gray-400 dark:text-gray-500"></span>
            </div>

            {{-- Textarea --}}
            <textarea
                x-model="content"
                @input="dirty = true; debouncedSave()"
                placeholder="{{ __('messages.note_placeholder') }}"
                rows="20"
                class="w-full px-5 py-4 bg-transparent text-sm text-gray-800 dark:text-gray-200
                       placeholder:text-gray-300 dark:placeholder:text-gray-600
                       focus:outline-none resize-none font-mono leading-relaxed">{{ $note->content }}</textarea>
        </div>
    </div>

    <script>
    function notepad(url, token) {
        return {
            content: @json($note->content),
            dirty: false,
            status: '',
            timer: null,

            debouncedSave() {
                clearTimeout(this.timer);
                this.status = '{{ __('messages.note_saving') }}';
                this.timer = setTimeout(() => this.save(), 1500);
            },

            async save() {
                if (! this.dirty) return;
                this.dirty = false;
                this.status = '{{ __('messages.note_saving') }}';

                await fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                    },
                    body: JSON.stringify({ content: this.content }),
                });

                this.status = '{{ __('messages.note_saved') }} ✓';
                setTimeout(() => { this.status = ''; }, 2000);
            },
        };
    }
    </script>
</x-layout>
