@props([
    'bind' => null,
    'label' => 'Radio Buttons',
    'required' => false,
    'cssClass' => '',
    'options' => []
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <label class="block text-sm font-medium text-slate-700 mb-2">
            <span x-text="{{ $bind }}.label || 'Radio Buttons'"></span>
            <template x-if="{{ $bind }}.required">
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            </template>
        </label>
        <div class="flex flex-col gap-2">
            <template x-for="(option, optIndex) in {{ $bind }}.options" :key="optIndex">
                <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                    <input 
                        type="radio" 
                        :name="'radio_' + {{ $bind }}.id" 
                        :value="option"
                        class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500"
                        :disabled="!showPreview"
                    />
                    <span class="ml-2" x-text="option"></span>
                </label>
            </template>
        </div>
    @else
        <label class="block text-sm font-medium text-slate-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            @endif
        </label>
        <div class="flex flex-col gap-2">
            @foreach($options as $option)
                <label class="inline-flex items-center text-sm text-slate-700 cursor-pointer">
                    <input 
                        type="radio" 
                        name="radio_{{ uniqid() }}" 
                        value="{{ $option }}"
                        class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500"
                    />
                    <span class="ml-2">{{ $option }}</span>
                </label>
            @endforeach
        </div>
    @endif
</div>
