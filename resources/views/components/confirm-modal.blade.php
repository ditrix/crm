<div x-data="{
        open: false,
        pendingForm: null,
        show(form) {
            this.pendingForm = form;
            this.open = true;
        },
        confirm() {
            if (this.pendingForm) {
                this.pendingForm.submit();
            }
            this.open = false;
        },
        cancel() {
            this.pendingForm = null;
            this.open = false;
        }
    }"
    @confirm-action.window="show($event.detail.form)"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center p-4"
    style="display:none">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="cancel()"></div>

    {{-- Modal --}}
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm p-6"
         @click.stop>

        {{-- Close button --}}
        <button type="button" @click="cancel()"
                class="absolute top-4 right-4 p-1 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
            <x-icon name="x-mark" class="w-5 h-5" />
        </button>

        {{-- Icon --}}
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 mx-auto mb-4">
            <x-icon name="exclamation-triangle" class="w-6 h-6 text-red-500" />
        </div>

        {{-- Message --}}
        <p class="text-center text-gray-700 dark:text-gray-300 text-sm font-medium mb-5">
            {{ __('messages.shure') }}
        </p>

        {{-- Actions --}}
        <div class="flex justify-center">
            <button type="button" @click="confirm()"
                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition">
                {{ __('messages.confirm') }}
            </button>
        </div>
    </div>
</div>
