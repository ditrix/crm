{{--
    Компонент загрузчика файлов с drag&drop
    Props:
        $fileableType — 'client' | 'deal'
        $fileableId   — int
        $files        — Collection<File>
--}}
<div
    x-data="fileUploader('{{ $fileableType }}', {{ $fileableId }})"
    class="space-y-4"
>
    {{-- Зона перетаскивания --}}
    <div
        class="border-2 border-dashed rounded-xl p-6 text-center transition-colors cursor-pointer"
        :class="dragging ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-blue-400'"
        @dragover.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @drop.prevent="handleDrop($event)"
        @click="$refs.fileInput.click()"
    >
        <input type="file" x-ref="fileInput" class="hidden" multiple @change="handleSelect($event)">
        <x-icon name="arrow-up-tray" class="w-8 h-8 mx-auto mb-2 text-gray-400 dark:text-gray-500" />
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('messages.files_drop_hint') }}
        </p>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
            PDF, Word, Excel, изображения, ZIP — до 10 MB
        </p>
    </div>

    {{-- Прогресс очереди --}}
    <template x-for="item in queue" :key="item.id">
        <div class="flex items-center gap-3 px-3 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm">
            <div class="flex-1 truncate" x-text="item.name"></div>
            <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                <div class="bg-blue-500 h-1.5 rounded-full transition-all" :style="'width:' + item.progress + '%'"></div>
            </div>
            <span class="text-xs text-gray-400" x-text="item.progress < 100 ? item.progress + '%' : '✓'"></span>
        </div>
    </template>

    {{-- Сообщение об ошибке --}}
    <p x-show="errorMsg" x-text="errorMsg" class="text-sm text-red-500"></p>

    {{-- Список уже загруженных файлов --}}
    <div class="space-y-2" id="file-list-{{ $fileableType }}-{{ $fileableId }}">
        @foreach($files as $file)
            <div
                class="flex items-center gap-3 px-3 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm group"
                id="file-row-{{ $file->id }}"
            >
                {{-- Иконка --}}
                <span class="text-lg leading-none">{{ $file->icon() }}</span>

                {{-- Название --}}
                <div class="flex-1 truncate">
                    <span class="text-gray-700 dark:text-gray-200 font-medium truncate block max-w-xs" title="{{ $file->original_name }}">
                        {{ $file->original_name }}
                    </span>
                    <span class="text-xs text-gray-400">{{ $file->formattedSize() }}</span>
                </div>

                {{-- Действия --}}
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    @if($file->isImage() || $file->isPdf())
                        <a
                            href="{{ route('files.view', $file) }}"
                            target="_blank"
                            class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400"
                            title="{{ __('messages.view') }}"
                        >
                            <x-icon name="eye" class="w-4 h-4" />
                        </a>
                    @endif
                    <a
                        href="{{ route('files.download', $file) }}"
                        class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400"
                        title="{{ __('messages.download') }}"
                    >
                        <x-icon name="arrow-down-tray" class="w-4 h-4" />
                    </a>
                    <button
                        type="button"
                        @click="removeFile({{ $file->id }})"
                        class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-red-400 hover:text-red-600"
                        title="{{ __('messages.delete') }}"
                    >
                        <x-icon name="trash" class="w-4 h-4" />
                    </button>
                </div>
            </div>
        @endforeach

        {{-- Новые файлы добавляются сюда через JS --}}
        <template x-for="f in uploaded" :key="f.id">
            <div
                class="flex items-center gap-3 px-3 py-2 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm group"
                :id="'file-row-' + f.id"
            >
                <span class="text-lg leading-none" x-text="f.is_image ? '🖼️' : '📄'"></span>
                <div class="flex-1 truncate">
                    <span class="text-gray-700 dark:text-gray-200 font-medium truncate block max-w-xs" x-text="f.original_name"></span>
                    <span class="text-xs text-gray-400" x-text="f.size"></span>
                </div>
                <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a :href="f.view_url" target="_blank" x-show="f.is_image"
                        class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400">
                        <x-icon name="eye" class="w-4 h-4" />
                    </a>
                    <a :href="f.download_url"
                        class="p-1.5 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 dark:text-gray-400">
                        <x-icon name="arrow-down-tray" class="w-4 h-4" />
                    </a>
                    <button type="button" @click="removeFile(f.id)"
                        class="p-1.5 rounded hover:bg-red-100 dark:hover:bg-red-900/30 text-red-400 hover:text-red-600">
                        <x-icon name="trash" class="w-4 h-4" />
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

<script>
function fileUploader(fileableType, fileableId) {
    return {
        dragging: false,
        queue: [],
        uploaded: [],
        errorMsg: '',
        queueCounter: 0,

        handleDrop(e) {
            this.dragging = false;
            this.uploadFiles(e.dataTransfer.files);
        },

        handleSelect(e) {
            this.uploadFiles(e.target.files);
        },

        uploadFiles(files) {
            Array.from(files).forEach(file => this.uploadOne(file));
        },

        uploadOne(file) {
            const id   = ++this.queueCounter;
            const item = { id, name: file.name, progress: 0 };
            this.queue.push(item);
            this.errorMsg = '';

            const formData = new FormData();
            formData.append('file', file);
            formData.append('fileable_type', fileableType);
            formData.append('fileable_id', fileableId);

            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', e => {
                if (e.lengthComputable) {
                    item.progress = Math.round((e.loaded / e.total) * 100);
                    this.queue = [...this.queue]; // trigger reactivity
                }
            });

            xhr.addEventListener('load', () => {
                this.queue = this.queue.filter(q => q.id !== id);
                if (xhr.status === 200) {
                    this.uploaded.push(JSON.parse(xhr.responseText));
                } else {
                    const resp = JSON.parse(xhr.responseText);
                    this.errorMsg = resp.message || '{{ __('messages.upload_error') }}';
                }
            });

            xhr.addEventListener('error', () => {
                this.queue = this.queue.filter(q => q.id !== id);
                this.errorMsg = '{{ __('messages.upload_error') }}';
            });

            xhr.open('POST', '{{ route('files.upload') }}');
            xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(formData);
        },

        removeFile(fileId) {
            if (!confirm('{{ __('messages.confirm_delete') }}')) return;

            fetch(`/files/${fileId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            }).then(res => {
                if (res.ok) {
                    // Remove from server-rendered list
                    const el = document.getElementById('file-row-' + fileId);
                    if (el) el.remove();
                    // Remove from uploaded (reactive)
                    this.uploaded = this.uploaded.filter(f => f.id !== fileId);
                }
            });
        },
    };
}
</script>
