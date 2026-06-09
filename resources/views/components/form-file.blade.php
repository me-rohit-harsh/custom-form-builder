@props([
    'bind' => null,
    'label' => 'File Upload',
    'required' => false,
    'cssClass' => ''
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <span x-text="{{ $bind }}.label || 'File Upload'"></span>
            <template x-if="{{ $bind }}.required">
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            </template>
        </label>
        <div class="flex items-center justify-center w-full">
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50/50 cursor-pointer hover:bg-slate-50 transition-colors duration-200">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-3 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-1 text-sm text-slate-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-slate-400">PDF, PNG, JPG or DOCX</p>
                </div>
                <input type="file" class="hidden" :disabled="!showPreview" />
            </label>
        </div>
    @else
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            @endif
        </label>
        <div class="flex items-center justify-center w-full">
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50/50 cursor-pointer hover:bg-slate-50 transition-colors duration-200">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-3 text-slate-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-1 text-sm text-slate-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-slate-400">PDF, PNG, JPG or DOCX</p>
                </div>
                <input type="file" class="hidden" />
            </label>
        </div>
    @endif
</div>
