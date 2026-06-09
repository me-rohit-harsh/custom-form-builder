@props([
    'bind' => null,
    'label' => 'Dropdown Select',
    'required' => false,
    'cssClass' => '',
    'options' => []
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            <span x-text="{{ $bind }}.label || 'Dropdown'"></span>
            <template x-if="{{ $bind }}.required">
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            </template>
        </label>
        <select 
            :required="{{ $bind }}.required"
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm appearance-none"
            style="background-image: url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22 fill=%22none%22 viewBox=%220 0 20 20%22%3E%3Cpath stroke=%22%236b7280%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%221.5%22 d=%22m6 8 4 4 4-4%22%2F%3E%3C%2Fsvg%3E'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.25rem;"
            :disabled="!showPreview"
        >
            <option value="" x-text="{{ $bind }}.placeholder || 'Select an option'"></option>
            <template x-for="option in {{ $bind }}.options" :key="option">
                <option :value="option" x-text="option"></option>
            </template>
        </select>
    @else
        <label class="block text-sm font-medium text-slate-700 mb-1.5">
            {{ $label }}
            @if($required)
                <span class="text-rose-500 font-semibold ml-0.5">*</span>
            @endif
        </label>
        <select 
            {{ $required ? 'required' : '' }}
            class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm"
        >
            <option value="">Select an option</option>
            @foreach($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    @endif
</div>
