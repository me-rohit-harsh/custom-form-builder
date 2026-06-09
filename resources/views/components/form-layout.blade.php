@props([
    'bind' => null,
    'type' => 'new_line', // title_desc, new_line, page_break, hidden
    'title' => '',
    'description' => '',
    'label' => '',
    'defaultValue' => '',
    'cssClass' => ''
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <!-- Title / Description -->
        <template x-if="{{ $bind }}.type === 'title_desc'">
            <div class="py-2">
                <h3 class="text-lg font-bold text-slate-800" x-text="{{ $bind }}.title || 'Section Title'"></h3>
                <p class="text-sm text-slate-500 mt-1" x-text="{{ $bind }}.description || 'Add a description here'"></p>
            </div>
        </template>

        <!-- New Line (Divider) -->
        <template x-if="{{ $bind }}.type === 'new_line'">
            <div class="py-2">
                <hr class="border-t border-dashed border-slate-200" />
            </div>
        </template>

        <!-- Page Break -->
        <template x-if="{{ $bind }}.type === 'page_break'">
            <div class="py-3 flex items-center justify-between border-y border-dashed border-indigo-200 bg-indigo-50/30 px-4 rounded-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Page Break
                </span>
                <span class="text-xs text-slate-400">Next fields will start on a new page</span>
            </div>
        </template>

        <!-- Hidden Field -->
        <template x-if="{{ $bind }}.type === 'hidden'">
            <div class="p-3 bg-slate-100/70 border border-slate-200 rounded-xl flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                    <span class="text-xs font-semibold text-slate-500">Hidden Field:</span>
                    <span class="text-xs text-slate-600" x-text="({{ $bind }}.label || 'Hidden') + ' (' + ({{ $bind }}.defaultValue || 'no default') + ')'"></span>
                </div>
                <span class="text-[10px] text-slate-400 font-mono" x-text="'id: ' + {{ $bind }}.id"></span>
            </div>
        </template>
    @else
        @if($type === 'title_desc')
            <div class="py-2">
                <h3 class="text-lg font-bold text-slate-800">{{ $title ?: 'Section Title' }}</h3>
                <p class="text-sm text-slate-500 mt-1">{{ $description ?: 'Add a description here' }}</p>
            </div>
        @elseif($type === 'new_line')
            <div class="py-2">
                <hr class="border-t border-dashed border-slate-200" />
            </div>
        @elseif($type === 'page_break')
            <div class="py-3 flex items-center justify-between border-y border-dashed border-indigo-200 bg-indigo-50/30 px-4 rounded-xl">
                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Page Break
                </span>
            </div>
        @elseif($type === 'hidden')
            <input type="hidden" name="{{ $label ?: 'hidden' }}" value="{{ $defaultValue }}" />
        @endif
    @endif
</div>
