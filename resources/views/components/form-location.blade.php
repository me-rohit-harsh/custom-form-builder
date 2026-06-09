@props([
    'bind' => null,
    'type' => 'state', // state, city, state_city
    'label' => '',
    'required' => false,
    'cssClass' => ''
])

<div class="mb-0 {{ $cssClass }}" @if($bind) :class="{{ $bind }}.cssClass" @endif>
    @if($bind)
        <!-- State selection -->
        <template x-if="{{ $bind }}.type === 'state'">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <span x-text="{{ $bind }}.label || 'State'"></span>
                    <template x-if="{{ $bind }}.required">
                        <span class="text-rose-500 font-semibold ml-0.5">*</span>
                    </template>
                </label>
                <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm" :disabled="!showPreview">
                    <option value="">Select State</option>
                    <option>California</option>
                    <option>Texas</option>
                    <option>New York</option>
                    <option>Florida</option>
                </select>
            </div>
        </template>

        <!-- City selection -->
        <template x-if="{{ $bind }}.type === 'city'">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <span x-text="{{ $bind }}.label || 'City'"></span>
                    <template x-if="{{ $bind }}.required">
                        <span class="text-rose-500 font-semibold ml-0.5">*</span>
                    </template>
                </label>
                <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm" :disabled="!showPreview">
                    <option value="">Select City</option>
                    <option>Los Angeles</option>
                    <option>Houston</option>
                    <option>New York City</option>
                    <option>Miami</option>
                </select>
            </div>
        </template>

        <!-- State & City Combined -->
        <template x-if="{{ $bind }}.type === 'state_city'">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    <span x-text="{{ $bind }}.label || 'Location Information'"></span>
                    <template x-if="{{ $bind }}.required">
                        <span class="text-rose-500 font-semibold ml-0.5">*</span>
                    </template>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 mb-1 block">State</span>
                        <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm" :disabled="!showPreview">
                            <option value="">Select State</option>
                            <option>California</option>
                            <option>Texas</option>
                            <option>New York</option>
                            <option>Florida</option>
                        </select>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 mb-1 block">City</span>
                        <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm" :disabled="!showPreview">
                            <option value="">Select City</option>
                            <option>Los Angeles</option>
                            <option>Houston</option>
                            <option>New York City</option>
                            <option>Miami</option>
                        </select>
                    </div>
                </div>
            </div>
        </template>
    @else
        @if($type === 'state')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    {{ $label ?: 'State' }}
                    @if($required) <span class="text-rose-500 font-semibold ml-0.5">*</span> @endif
                </label>
                <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm">
                    <option value="">Select State</option>
                    <option>California</option>
                    <option>Texas</option>
                    <option>New York</option>
                    <option>Florida</option>
                </select>
            </div>
        @elseif($type === 'city')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    {{ $label ?: 'City' }}
                    @if($required) <span class="text-rose-500 font-semibold ml-0.5">*</span> @endif
                </label>
                <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm">
                    <option value="">Select City</option>
                    <option>Los Angeles</option>
                    <option>Houston</option>
                    <option>New York City</option>
                    <option>Miami</option>
                </select>
            </div>
        @elseif($type === 'state_city')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    {{ $label ?: 'Location Information' }}
                    @if($required) <span class="text-rose-500 font-semibold ml-0.5">*</span> @endif
                </label>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 mb-1 block">State</span>
                        <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm">
                            <option value="">Select State</option>
                            <option>California</option>
                            <option>Texas</option>
                            <option>New York</option>
                            <option>Florida</option>
                        </select>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 mb-1 block">City</span>
                        <select class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 text-slate-800 rounded-xl focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 shadow-sm text-sm">
                            <option value="">Select City</option>
                            <option>Los Angeles</option>
                            <option>Houston</option>
                            <option>New York City</option>
                            <option>Miami</option>
                        </select>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>
