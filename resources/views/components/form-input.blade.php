@props([
    'bind' => null,
    'label' => 'Text Field',
    'type' => 'text',
    'placeholder' => 'Enter text...',
    'required' => false,
    'cssClass' => '',
    'defaultValue' => '',
    'min' => null,
    'max' => null
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <span x-text="{{ $bind }}.label || 'Input Field'"></span>
            <template x-if="{{ $bind }}.required">
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            </template>
        </label>
        <input 
            :type="{{ $bind }}.type === 'phone' ? 'tel' : ({{ $bind }}.type === 'date' ? 'date' : ({{ $bind }}.type === 'number' ? 'number' : ({{ $bind }}.type === 'email' ? 'email' : 'text')))" 
            :placeholder="{{ $bind }}.placeholder"
            :required="{{ $bind }}.required"
            :minlength="({{ $bind }}.type === 'text' || {{ $bind }}.type === 'email') ? ({{ $bind }}.min || undefined) : undefined"
            :maxlength="({{ $bind }}.type === 'text' || {{ $bind }}.type === 'email') ? ({{ $bind }}.max || undefined) : undefined"
            :min="{{ $bind }}.type === 'number' ? ({{ $bind }}.min || undefined) : undefined"
            :max="{{ $bind }}.type === 'number' ? ({{ $bind }}.max || undefined) : undefined"
            :value="{{ $bind }}.defaultValue"
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm"
            :disabled="!showPreview"
        />
    @else
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            @endif
        </label>
        <input 
            type="{{ $type === 'phone' ? 'tel' : ($type === 'number' ? 'number' : ($type === 'email' ? 'email' : $type)) }}" 
            placeholder="{{ $placeholder }}"
            {{ $required ? 'required' : '' }}
            @if($min !== null && $min !== '') 
                @if($type === 'number') min="{{ $min }}" @else minlength="{{ $min }}" @endif
            @endif
            @if($max !== null && $max !== '') 
                @if($type === 'number') max="{{ $max }}" @else maxlength="{{ $max }}" @endif
            @endif
            value="{{ $defaultValue }}"
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm"
        />
    @endif
</div>
