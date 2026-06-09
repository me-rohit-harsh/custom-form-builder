@props([
    'bind' => null,
    'label' => 'Text Area',
    'placeholder' => 'Enter text...',
    'required' => false,
    'cssClass' => '',
    'min' => null,
    'max' => null,
    'defaultValue' => ''
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <span x-text="{{ $bind }}.label || 'Text Area'"></span>
            <template x-if="{{ $bind }}.required">
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            </template>
        </label>
        <textarea 
            :placeholder="{{ $bind }}.placeholder"
            :required="{{ $bind }}.required"
            :minlength="{{ $bind }}.min || undefined"
            :maxlength="{{ $bind }}.max || undefined"
            x-text="{{ $bind }}.defaultValue"
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm min-h-[100px]"
            :disabled="!showPreview"
        ></textarea>
    @else
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            @endif
        </label>
        <textarea 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            @if($min !== null && $min !== '') minlength="{{ $min }}" @endif
            @if($max !== null && $max !== '') maxlength="{{ $max }}" @endif
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm min-h-[100px]"
        >{{ $defaultValue }}</textarea>
    @endif
</div>
