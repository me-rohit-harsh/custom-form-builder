@extends('layouts.admin')
@section('content')
				<div class="app-content">
					<div class="side-app">

    <div id="form-builder-app" 
         x-data="formBuilder" 
         x-cloak 
         class="min-h-screen flex flex-col bg-gradient-to-tr from-slate-100 via-indigo-50/10 to-slate-50">
        
        <!-- Top header -->
<header class="mt-5 bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm/5">            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                   
                    <div>
                        <span class="text-lg font-bold text-slate-800 tracking-tight">Custom Form Builder</span>
                        <span class="ml-1.5 px-2 py-0.5 text-[10px] font-semibold bg-indigo-50 text-indigo-600 rounded-full border border-indigo-100">v1.0</span>
                    </div>
                </div>

                <!-- Tab buttons -->
                <div class="flex space-x-1 bg-slate-100 p-1 rounded-xl">
                    <button type="button" 
                            @click="activeTab = 'editor'" 
                            :class="activeTab === 'editor' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-1.5 text-xs font-semibold rounded-lg transition-all duration-150">
                        Form Editor
                    </button>
                    <button type="button" 
                            @click="activeTab = 'settings'" 
                            :class="activeTab === 'settings' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-600 hover:text-slate-900'"
                            class="px-4 py-1.5 text-xs font-semibold rounded-lg transition-all duration-150">
                        Settings
                    </button>
                </div>

                <!-- Right side actions -->
                <div class="flex items-center space-x-3">
                    <!-- Undo / Redo -->
                    <div class="flex items-center bg-slate-100 p-1 rounded-xl space-x-0.5">
                        <button type="button" 
                                @click="undo()" 
                                :disabled="historyIndex <= 0"
                                :class="historyIndex <= 0 ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-white hover:text-slate-850'"
                                class="p-1.5 rounded-lg transition-all duration-150"
                                title="Undo (Ctrl+Z)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0019 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.066 11.2a1 1 0 000 1.6l5.334 4A1 1 0 0011 16V8a1 1 0 00-1.6-.8l-5.334 4z"></path></svg>
                        </button>
                        <button type="button" 
                                @click="redo()" 
                                :disabled="historyIndex >= history.length - 1"
                                :class="historyIndex >= history.length - 1 ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-white hover:text-slate-850'"
                                class="p-1.5 rounded-lg transition-all duration-150"
                                title="Redo (Ctrl+Y)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.934 12.8a1 1 0 000-1.6l-5.334-4A1 1 0 005 8v8a1 1 0 001.6.8l5.334-4z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.934 12.8a1 1 0 000-1.6l-5.334-4A1 1 0 0013 8v8a1 1 0 001.6.8l5.334-4z"></path></svg>
                        </button>
                    </div>

                    <!-- Preview toggle -->
                    <button type="button" 
                            @click="togglePreview()"
                            :class="showPreview ? 'bg-rose-50 text-rose-600 border-rose-200 hover:bg-rose-100' : 'bg-indigo-50 text-indigo-600 border-indigo-200 hover:bg-indigo-100'"
                            class="px-4 py-2 text-xs font-semibold rounded-xl border flex items-center space-x-1.5 shadow-sm transition-all duration-200">
                        <template x-if="!showPreview">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Preview
                            </span>
                        </template>
                        <template x-if="showPreview">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Back to Editor
                            </span>
                        </template>
                    </button>
                </div>
            </div>
        </header>

        <!-- Main content -->
<main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-8 flex flex-col space-y-6">            

            <div x-show="activeTab === 'editor'" class="flex flex-col space-y-6" x-transition>
                <!-- Form title and URL -->
                <div class="bg-white/80 backdrop-blur-md border border-slate-200/85 rounded-2xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex-grow space-y-2">
                        <!-- Title input with char counter -->
                        <div class="relative max-w-xl">
                            <input type="text" 
                                   x-model="title" 
                                   maxlength="200" 
                                   @input="saveHistory()"
                                   placeholder="Give your form a name..."
                                   class="text-2xl font-bold tracking-tight text-slate-800 focus:outline-none bg-transparent placeholder-slate-400 w-full pr-14 border-b border-transparent focus:border-slate-300 pb-1 transition duration-150" />
                            <span class="absolute right-0 bottom-2 text-[10px] font-semibold text-slate-400 bg-slate-100/80 px-2 py-0.5 rounded-full" 
                                  x-text="title.length + '/200'">
                            </span>
                        </div>
                        
                        <!-- Submission URL -->
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-0.5 text-[9px] font-bold tracking-wide uppercase bg-emerald-50 text-emerald-600 rounded border border-emerald-100">POST URL</span>
                            <div class="group relative flex-grow max-w-md">
                                <input type="text" 
                                       x-model="submissionUrl" 
                                       @input="persist()"
                                       class="text-xs text-slate-500 bg-transparent hover:bg-slate-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:outline-none rounded px-1.5 py-0.5 w-full transition" />
                            </div>
                        </div>
                    </div>
                    
                    <!-- Field count & clear button -->
                    <div class="flex items-center space-x-6 text-sm text-slate-500 shrink-0 md:border-l border-slate-200 md:pl-6">
                        <div class="text-center">
                            <span class="block text-xl font-bold text-slate-800" x-text="fields.length"></span>
                            <span class="text-xs text-slate-400 font-medium uppercase tracking-wider">Placed Fields</span>
                        </div>
                        <button type="button" 
                                @click="clearForm()" 
                                class="px-3.5 py-2 text-xs font-semibold text-rose-600 hover:text-white border border-rose-200 hover:bg-rose-600 rounded-xl transition duration-150 shadow-sm/5">
                            Clear Canvas
                        </button>
                    </div>
                </div>

                <!-- Main grid layout -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    <!-- Left panel - form canvas -->
                    <section :class="showPreview ? 'lg:col-span-12 max-w-4xl mx-auto w-full' : 'lg:col-span-8'"
                             class="flex flex-col transition-all duration-300">
                             

                        
                        <!-- Canvas area -->
                        <div @dragenter="if (!showPreview) dragOver = true" 
                             @dragleave="if (!showPreview) dragOver = false" 
                             @drop="dragOver = false" 
                             :class="[
                                 dragOver ? 'border-indigo-500 bg-indigo-50/20 ring-4 ring-indigo-500/5' : 'border-slate-350 bg-white/40',
                                 showPreview ? 'p-8 border rounded-3xl shadow-sm bg-white' : 'p-6 border-2 border-dashed rounded-2xl min-h-[550px]'
                             ]"
                             class="transition-all duration-300 relative flex flex-col">
                             
                            <!-- Title shown in preview -->
                            <div x-show="showPreview" class="border-b border-slate-100 pb-5 mb-6">
                                <h1 class="text-3xl font-extrabold text-slate-800" x-text="title || 'Form response'"></h1>
                                <p class="text-sm text-slate-400 mt-1" x-text="'Posting to: ' + submissionUrl"></p>
                            </div>

                            <!-- Empty state message -->
                            <div x-show="fields.length === 0" 
                                 class="absolute inset-0 flex flex-col items-center justify-center text-center p-8 pointer-events-none select-none">
                                <div class="h-16 w-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-4 border border-slate-200">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <h3 class="text-base font-bold text-slate-700 mb-1">Canvas is empty</h3>
                                <p class="text-sm text-slate-400 max-w-sm">Drag fields from the right panel to start building your form.</p>
                            </div>

                            <!-- Fields list -->
                            <form @submit.prevent="submitPreviewForm()" class="h-full flex flex-col flex-grow">
                                <div id="canvas-items" class="flex flex-col gap-4 min-h-[480px] flex-grow">
                                    
                                    <!-- Field loop -->
                                    <template x-for="(field, index) in fields" :key="field.id">
                                        <div x-data="{ hovered: false }"
                                             @mouseenter="hovered = true"
                                             @mouseleave="hovered = false"
                                             class="relative p-3 bg-white border border-slate-200 rounded-2xl transition-all duration-200"
                                             :class="[
                                                 selectedFieldId === field.id && !showPreview ? 'ring-2 ring-indigo-550 border-transparent shadow-md' : 'hover:shadow-sm hover:border-slate-300',
                                                 showPreview ? '' : 'cursor-default'
                                             ]"
                                             @click="if (!showPreview) selectField(field.id)">
                                             
                                             <!-- Hover action buttons -->
                                             <div x-show="!showPreview && hovered" 
                                                  x-transition
                                                  class="absolute -top-3.5 right-3 flex items-center space-x-1 bg-white border border-slate-200 shadow-md px-1.5 py-1 rounded-xl z-20">
                                                 
                                                 <!-- Drag handle -->
                                                 <button type="button" class="drag-handle p-1 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-slate-50 transition" title="Drag to Reorder">
                                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8M8 15h8"></path></svg>
                                                 </button>
                                                 
                                                 <!-- Edit -->
                                                 <button type="button" @click.stop="selectField(field.id)" class="p-1 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-slate-50 transition" title="Configure Field">
                                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.007 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75-4.365-9.75-9.75-9.75zm3.87 6.474l-4.5 4.5a.75.75 0 01-1.06 0l-2-2a.75.75 0 111.06-1.06l1.47 1.47 3.97-3.97a.75.75 0 111.06 1.06z"></path></svg>
                                                 </button>
                                                 
                                                 <!-- Duplicate -->
                                                 <button type="button" @click.stop="duplicateField(field.id)" class="p-1 text-slate-400 hover:text-indigo-600 rounded-lg hover:bg-slate-50 transition" title="Duplicate Field">
                                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m10.5 11.25a2.25 2.25 0 01-2.25 2.25h-6a2.25 2.25 0 01-2.25-2.25v-11.25"></path></svg>
                                                 </button>
                                                 
                                                 <!-- Delete -->
                                                 <button type="button" @click.stop="deleteField(field.id)" class="p-1 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition" title="Remove Field">
                                                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                                 </button>
                                             </div>

                                             <!-- Render field component based on type -->
                                             <div :class="showPreview ? 'pointer-events-auto' : 'pointer-events-none'">
                                                 
                                                 <!-- Text inputs -->
                                                 <template x-if="['text', 'number', 'email', 'phone', 'date'].includes(field.type)">
                                                     <x-form-input bind="field" />
                                                 </template>
                                                 
                                                 <!-- Textarea -->
                                                 <template x-if="field.type === 'textarea'">
                                                     <x-form-textarea bind="field" />
                                                 </template>
                                                 
                                                 <!-- Dropdown -->
                                                 <template x-if="field.type === 'select'">
                                                     <x-form-select bind="field" />
                                                 </template>
                                                 
                                                 <!-- Radio -->
                                                 <template x-if="field.type === 'radio'">
                                                     <x-form-radio-group bind="field" />
                                                 </template>
                                                 
                                                 <!-- Checkboxes -->
                                                 <template x-if="field.type === 'checkbox'">
                                                     <x-form-checkbox-group bind="field" />
                                                 </template>
                                                 
                                                 <!-- File Upload -->
                                                 <template x-if="field.type === 'file'">
                                                     <x-form-file bind="field" />
                                                 </template>
                                                 
                                                 <!-- Location Fields -->
                                                 <template x-if="['state', 'city', 'state_city'].includes(field.type)">
                                                     <x-form-location bind="field" />
                                                 </template>
                                                 
                                                 <!-- Layout elements -->
                                                 <template x-if="['title_desc', 'new_line', 'page_break', 'hidden'].includes(field.type)">
                                                     <x-form-layout bind="field" />
                                                 </template>
                                                 
                                             </div>
                                        </div>
                                    </template>
                                    
                                </div>

                                <!-- Submit button (preview only) -->
                                <div x-show="showPreview && fields.length > 0" class="mt-8 pt-5 border-t border-slate-100 flex justify-end">
                                    <button type="submit" 
                                            :class="{
                                                'bg-indigo-600 hover:bg-indigo-700 shadow-indigo-600/10': formSettings.submitButtonColor === 'indigo',
                                                'bg-rose-600 hover:bg-rose-700 shadow-rose-600/10': formSettings.submitButtonColor === 'rose',
                                                'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/10': formSettings.submitButtonColor === 'emerald',
                                                'bg-slate-700 hover:bg-slate-800 shadow-slate-600/10': formSettings.submitButtonColor === 'slate'
                                            }"
                                            class="px-6 py-3 text-sm font-semibold text-white rounded-xl shadow-lg transition-all duration-200" 
                                            x-text="formSettings.submitButtonText || 'Submit Response'">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </section>

                    <!-- Right panel - field palette -->
                    <aside x-show="!showPreview" 
                           x-transition:enter="transition ease-out duration-200"
                           x-transition:enter-start="opacity-0 translate-x-4"
                           x-transition:enter-end="opacity-100 translate-x-0"
                           x-transition:leave="transition ease-in duration-150"
                           x-transition:leave-start="opacity-100 translate-x-0"
                           x-transition:leave-end="opacity-0 translate-x-4"
                           class="lg:col-span-4 sticky top-24">
                        
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col max-h-[750px]">
                            
                            <!-- Panel tabs -->
                            <div class="flex border-b border-slate-100 bg-slate-50/50 p-1">
                                <button type="button" 
                                        @click="paletteTab = 'add'"
                                        :class="paletteTab === 'add' ? 'bg-white text-slate-800 shadow-sm border border-slate-200/50' : 'text-slate-500 hover:text-slate-800'"
                                        class="flex-1 py-2 text-xs font-semibold rounded-xl transition-all duration-150">
                                    Add Fields
                                </button>
                                <button type="button" 
                                        @click="paletteTab = 'options'"
                                        :class="paletteTab === 'options' ? 'bg-white text-slate-800 shadow-sm border border-slate-200/50' : 'text-slate-500 hover:text-slate-800'"
                                        class="flex-1 py-2 text-xs font-semibold rounded-xl transition-all duration-150 relative">
                                    Field Options
                                    <template x-if="selectedField">
                                        <span class="absolute top-1.5 right-4 h-2 w-2 bg-indigo-600 rounded-full"></span>
                                    </template>
                                </button>
                            </div>

                            <!-- Panel content -->
                            <div class="overflow-y-auto p-5 space-y-6">
                                
                                <!-- Add fields tab -->
                                <div x-show="paletteTab === 'add'" class="space-y-6">
                                    <div id="palette-items" class="space-y-5">
                                        
                                        <!-- Standard inputs -->
                                        <div>
                                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-2.5">Standard Fields</h4>
                                            <div class="grid grid-cols-2 gap-3 palette-grid">
                                                
                                                <!-- Text -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="text">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-9v14"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Text Input</span>
                                                </div>
                                                
                                                <!-- Textarea -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="textarea">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Text Area</span>
                                                </div>

                                                <!-- Number -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="number">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Number</span>
                                                </div>

                                                <!-- Email -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="email">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Email</span>
                                                </div>

                                                <!-- Phone -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="phone">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Phone</span>
                                                </div>

                                                <!-- Date -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="date">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Date Picker</span>
                                                </div>

                                                <!-- File upload -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="file">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">File Upload</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Choice fields -->
                                        <div>
                                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-2.5">Choices & Lists</h4>
                                            <div class="grid grid-cols-2 gap-3 palette-grid">
                                                
                                                <!-- Dropdown -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="select">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Dropdown</span>
                                                </div>
                                                
                                                <!-- Radio -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="radio">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Radio Buttons</span>
                                                </div>

                                                <!-- Checkbox -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="checkbox">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Checkboxes</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Layout fields -->
                                        <div>
                                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-2.5">Structure & Layout</h4>
                                            <div class="grid grid-cols-2 gap-3 palette-grid">
                                                
                                                <!-- Title block -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="title_desc">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Header Block</span>
                                                </div>
                                                
                                                <!-- Divider -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="new_line">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">New Line</span>
                                                </div>

                                                <!-- Page break -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="page_break">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Page Break</span>
                                                </div>

                                                <!-- Hidden -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="hidden">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">Hidden Field</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Location fields -->
                                        <div>
                                            <h4 class="text-[10px] font-bold uppercase tracking-wider text-slate-450 mb-2.5">Location & Geolocation</h4>
                                            <div class="grid grid-cols-2 gap-3 palette-grid">
                                                
                                                <!-- State -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="state">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">State</span>
                                                </div>
                                                
                                                <!-- City -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="city">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">City</span>
                                                </div>

                                                <!-- State + City combo -->
                                                <div class="palette-item group flex items-center p-2.5 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white hover:border-indigo-550 hover:shadow-sm cursor-grab transition duration-150" data-type="state_city">
                                                    <span class="p-1.5 bg-indigo-50 text-indigo-650 rounded-lg mr-2.5 group-hover:bg-indigo-100 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2l6 3 5.447-2.724A1 1 0 0121 3.176v10.764a1 1 0 01-.553.894L15 18l-6 2z"></path></svg>
                                                    </span>
                                                    <span class="text-xs font-medium text-slate-700">State & City</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Field options tab -->
                                <div x-show="paletteTab === 'options'" class="space-y-5">
                                    
                                    <!-- No field selected -->
                                    <div x-show="!selectedField" class="text-center py-8">
                                        <div class="h-12 w-12 bg-slate-50 border border-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-700">No element selected</h4>
                                        <p class="text-[11px] text-slate-400 max-w-[200px] mx-auto mt-1">Click on any field to see its options here.</p>
                                    </div>

                                    <!-- Field config form -->
                                    <template x-if="selectedField">
                                        <div class="space-y-4">
                                        <div class="pb-3 border-b border-slate-100 flex items-center justify-between">
                                            <span class="text-xs font-bold uppercase tracking-wider text-slate-400" x-text="selectedField ? selectedField.type + ' options' : ''"></span>
                                            <span class="text-[10px] font-mono bg-slate-100 text-slate-505 px-2 py-0.5 rounded" x-text="selectedField ? 'id: ' + selectedField.id.substr(6, 6) : ''"></span>
                                        </div>

                                        <!-- Label -->
                                        <div>
                                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Field Label</label>
                                            <input type="text" x-model="selectedField.label" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                        </div>

                                        <!-- Title & description (for header blocks) -->
                                        <template x-if="selectedField && selectedField.type === 'title_desc'">
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Section Title</label>
                                                    <input type="text" x-model="selectedField.title" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Section Description</label>
                                                    <textarea x-model="selectedField.description" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm min-h-[70px]"></textarea>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Placeholder -->
                                        <template x-if="selectedField && ['text', 'textarea', 'email', 'phone', 'number', 'select'].includes(selectedField.type)">
                                            <div>
                                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Placeholder Text</label>
                                                <input type="text" x-model="selectedField.placeholder" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                            </div>
                                        </template>

                                        <!-- Default value -->
                                        <template x-if="selectedField && ['text', 'number', 'email', 'hidden'].includes(selectedField.type)">
                                            <div>
                                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Default Value</label>
                                                <input :type="selectedField.type === 'number' ? 'number' : 'text'" x-model="selectedField.defaultValue" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                            </div>
                                        </template>

                                        <!-- Min / Max -->
                                        <template x-if="selectedField && ['text', 'textarea', 'number'].includes(selectedField.type)">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div>
                                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1" x-text="selectedField.type === 'number' ? 'Min Value' : 'Min Length'"></label>
                                                    <input type="number" x-model="selectedField.min" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                                </div>
                                                <div>
                                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1" x-text="selectedField.type === 'number' ? 'Max Value' : 'Max Length'"></label>
                                                    <input type="number" x-model="selectedField.max" @input="persist()" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Options list (dropdown/radio/checkbox) -->
                                        <template x-if="selectedField && ['select', 'radio', 'checkbox'].includes(selectedField.type)">
                                            <div class="space-y-2.5">
                                                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Options List</label>
                                                <div class="space-y-2">
                                                    <template x-for="(opt, optIdx) in selectedField.options" :key="optIdx">
                                                        <div class="flex items-center space-x-2">
                                                            <input type="text" 
                                                                   :value="opt" 
                                                                   @input="updateOption(optIdx, $event.target.value)" 
                                                                   class="flex-grow px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none text-xs" />
                                                            <button type="button" 
                                                                    @click="removeOption(optIdx)" 
                                                                    class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-slate-50 transition" 
                                                                    title="Remove Option">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                                <button type="button" 
                                                        @click="addOption()" 
                                                        class="w-full mt-1.5 py-2 border border-dashed border-indigo-200 hover:border-indigo-500 text-indigo-650 hover:bg-indigo-50/20 text-xs font-semibold rounded-xl transition duration-150">
                                                    + Add Option Row
                                                </button>
                                            </div>
                                        </template>

                                        <!-- CSS class -->
                                        <div>
                                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Custom CSS Class</label>
                                            <input type="text" x-model="selectedField.cssClass" @input="persist()" placeholder="e.g. mb-8, border-indigo-200" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-xs shadow-sm" />
                                        </div>

                                        <!-- Required toggle -->
                                        <div class="flex items-center justify-between p-3 bg-slate-50/50 border border-slate-200/60 rounded-xl mt-4">
                                            <div class="space-y-0.5">
                                                <span class="block text-xs font-bold text-slate-700">Required Field</span>
                                                <span class="block text-[10px] text-slate-450">User must fill this field</span>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" x-model="selectedField.required" @change="saveHistory()" class="sr-only peer">
                                                <div class="w-9 h-5 bg-slate-250 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600"></div>
                                            </label>
                                        </div>

                                        <!-- Delete field button -->
                                        <div class="pt-4 mt-4 border-t border-slate-100">
                                            <button type="button" 
                                                    @click="deleteField(selectedField.id)"
                                                    class="w-full py-2.5 bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white border border-rose-250 hover:border-transparent text-xs font-bold rounded-xl transition duration-200 flex items-center justify-center space-x-1.5">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                <span>Remove Field</span>
                                            </button>
                                        </div>

                                        </div>
                                    </template>
                                </div>

                            </div>
                        </div>
                    </aside>

                </div>
            </div>

            <!-- Settings Tab Content -->
            <div x-show="activeTab === 'settings'" class="flex flex-col space-y-6" x-transition x-cloak>
                <div class="bg-white/80 backdrop-blur-md border border-slate-200/85 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-800 mb-6">Form Settings</h2>
                    
                    <div class="max-w-2xl space-y-8">
                       
                        <div class="pt-6 border-t border-slate-100 flex items-center">
                            <button type="button" 
                                    @click="activeTab = 'editor'" 
                                    class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/10 transition duration-150 flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span>Go to Editor</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="bg-white/80 backdrop-blur-md border border-slate-200 rounded-2xl p-4 shadow-sm flex items-center justify-between">
                <button type="button" 
                        @click="clearForm()" 
                        class="px-5 py-2.5 text-xs font-semibold text-slate-650 hover:text-slate-900 border border-slate-250 hover:border-slate-400 bg-white rounded-xl transition duration-150 shadow-sm/5">
                    Reset Form
                </button>
                <button type="button" 
                        @click="exportSchema()" 
                        class="px-6 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-600/10 transition duration-150">
Generate JSON                </button>
            </footer>

        </main>
        
       <!-- Toast notifications -->
<div class="fixed bottom-6 inset-x-0 z-50 flex flex-col items-center space-y-3 pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-y-2"
            :class="{
                'bg-slate-900 text-white': toast.type === 'info',
                'bg-emerald-600 text-white': toast.type === 'success',
                'bg-rose-600 text-white': toast.type === 'warning'
            }"
            class="px-4 py-3 rounded-xl shadow-lg flex items-center space-x-3 pointer-events-auto"
        >
            <span class="text-xs font-semibold" x-text="toast.message"></span>
        </div>
    </template>
</div>

    </div>

    <!-- JS logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('formBuilder', () => ({
                title: 'Untitled Form',
                submissionUrl: 'https://api.example.com/v1/submissions',
                activeTab: 'editor',
                paletteTab: 'add',
                fields: [],
                selectedFieldId: null,
                showPreview: false,
                dragOver: false,
                
                
                history: [],
                historyIndex: -1,
                
                
                formSettings: {
                    submitButtonText: 'Submit Response',
                    submitButtonColor: 'indigo',
                    customCss: ''
                },
                
                
                toasts: [],
                
                init() {
                    // load saved data from localStorage
                    const savedData = localStorage.getItem('form_builder_state');
                    if (savedData) {
                        try {
                            const parsed = JSON.parse(savedData);
                            this.title = parsed.title || 'Untitled Form';
                            this.submissionUrl = parsed.submissionUrl || 'https://api.example.com/v1/submissions';
                            this.fields = parsed.fields || [];
                            this.formSettings = parsed.formSettings || {
                                submitButtonText: 'Submit Response',
                                submitButtonColor: 'indigo',
                                customCss: ''
                            };
                        } catch (e) {
                            console.error('Error parsing saved state', e);
                        }
                    }
                    
                    // save first history entry
                    this.saveHistory();
                    
                    // setup sortable after DOM is ready
                    this.$nextTick(() => {
                        this.initSortable();
                    });
                    
                    // keyboard shortcuts for undo/redo
                    window.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'z') {
                            e.preventDefault();
                            this.undo();
                        } else if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'y') {
                            e.preventDefault();
                            this.redo();
                        }
                    });
                },
                
                saveHistory() {
                    // if we undid some steps, cut off the future history
                    if (this.historyIndex < this.history.length - 1) {
                        this.history = this.history.slice(0, this.historyIndex + 1);
                    }
                    
                    // save a copy of current state
                    this.history.push({
                        fields: JSON.parse(JSON.stringify(this.fields)),
                        title: this.title,
                        submissionUrl: this.submissionUrl,
                        formSettings: JSON.parse(JSON.stringify(this.formSettings))
                    });
                    this.historyIndex = this.history.length - 1;
                    
                    // save to localStorage
                    this.persist();
                },
                
                persist() {
                    localStorage.setItem('form_builder_state', JSON.stringify({
                        title: this.title,
                        submissionUrl: this.submissionUrl,
                        fields: this.fields,
                        formSettings: this.formSettings
                    }));
                },
                
                undo() {
                    if (this.historyIndex > 0) {
                        this.historyIndex--;
                        const state = this.history[this.historyIndex];
                        this.fields = JSON.parse(JSON.stringify(state.fields));
                        this.title = state.title;
                        this.submissionUrl = state.submissionUrl;
                        this.formSettings = JSON.parse(JSON.stringify(state.formSettings));
                        this.showToast('Undone', 'info');
                        this.persist();
                    } else {
                        this.showToast('Nothing to undo', 'warning');
                    }
                },
                
                redo() {
                    if (this.historyIndex < this.history.length - 1) {
                        this.historyIndex++;
                        const state = this.history[this.historyIndex];
                        this.fields = JSON.parse(JSON.stringify(state.fields));
                        this.title = state.title;
                        this.submissionUrl = state.submissionUrl;
                        this.formSettings = JSON.parse(JSON.stringify(state.formSettings));
                        this.showToast('Redone', 'info');
                        this.persist();
                    } else {
                        this.showToast('Nothing to redo', 'warning');
                    }
                },
                
                initSortable() {
                    // make palette items draggable
                    const paletteGrids = document.querySelectorAll('.palette-grid');
                    if (paletteGrids.length && window.Sortable) {
                        paletteGrids.forEach(el => {
                            new Sortable(el, {
                                group: {
                                    name: 'fields',
                                    pull: 'clone',
                                    put: false
                                },
                                sort: false,
                                helper: 'clone',
                                animation: 150
                            });
                        });
                    }
                    
                    // setup canvas as drop target
                    const canvasEl = document.getElementById('canvas-items');
                    if (canvasEl && window.Sortable) {
                        new Sortable(canvasEl, {
                            group: {
                                name: 'fields',
                                pull: true,
                                put: true
                            },
                            handle: '.drag-handle',
                            animation: 200,
                            ghostClass: 'bg-indigo-50/50',
                            chosenClass: 'border-indigo-500',
                            dragClass: 'shadow-md',
                            
                            onAdd: (evt) => {
                                const type = evt.item.getAttribute('data-type');
                                const newIndex = evt.newIndex;
                                
                                const newField = {
                                    id: 'field_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9),
                                    type: type,
                                    label: this.getDefaultLabel(type),
                                    placeholder: this.getDefaultPlaceholder(type),
                                    required: false,
                                    min: '',
                                    max: '',
                                    options: ['select', 'radio', 'checkbox'].includes(type) ? ['Option 1', 'Option 2', 'Option 3'] : [],
                                    cssClass: '',
                                    defaultValue: '',
                                    title: type === 'title_desc' ? 'Section Title' : '',
                                    description: type === 'title_desc' ? 'Add a description here' : ''
                                };
                                
                                this.fields.splice(newIndex, 0, newField);
                                this.selectField(newField.id);
                                this.saveHistory();
                                
                                // remove the DOM element sortable added, alpine handles the rendering
                                evt.item.remove();
                            },
                            
                            onUpdate: (evt) => {
                                const oldIndex = evt.oldIndex;
                                const newIndex = evt.newIndex;
                                
                                const movedField = this.fields.splice(oldIndex, 1)[0];
                                this.fields.splice(newIndex, 0, movedField);
                                this.saveHistory();
                            }
                        });
                    }
                },
                
                getDefaultLabel(type) {
                    switch(type) {
                        case 'text': return 'Text Input';
                        case 'textarea': return 'Text Area';
                        case 'number': return 'Number Input';
                        case 'email': return 'Email Address';
                        case 'phone': return 'Phone Number';
                        case 'select': return 'Dropdown Select';
                        case 'radio': return 'Radio Buttons';
                        case 'checkbox': return 'Checkboxes';
                        case 'date': return 'Date Picker';
                        case 'file': return 'File Upload';
                        case 'title_desc': return 'Title & Description';
                        case 'new_line': return 'New Line Divider';
                        case 'page_break': return 'Page Break';
                        case 'hidden': return 'Hidden Field';
                        case 'state': return 'State Selection';
                        case 'city': return 'City Selection';
                        case 'state_city': return 'State & City';
                        default: return 'Field';
                    }
                },
                
                getDefaultPlaceholder(type) {
                    switch(type) {
                        case 'text': return 'Type here...';
                        case 'textarea': return 'Write something...';
                        case 'number': return 'Enter number...';
                        case 'email': return 'you@example.com';
                        case 'phone': return '+91 98765 43210';
                        default: return '';
                    }
                },
                
                selectField(id) {
                    this.selectedFieldId = id;
                    this.paletteTab = 'options';
                },
                
                get selectedField() {
                    return this.fields.find(f => f.id === this.selectedFieldId) || null;
                },
                
                duplicateField(id) {
                    const index = this.fields.findIndex(f => f.id === id);
                    if (index !== -1) {
                        const original = this.fields[index];
                        const clone = JSON.parse(JSON.stringify(original));
                        clone.id = 'field_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
                        clone.label = original.label + ' (Copy)';
                        this.fields.splice(index + 1, 0, clone);
                        this.selectField(clone.id);
                        this.saveHistory();
                        this.showToast('Copied!', 'success');
                    }
                },
                
                deleteField(id) {
                    this.fields = this.fields.filter(f => f.id !== id);
                    if (this.selectedFieldId === id) {
                        this.selectedFieldId = null;
                        this.paletteTab = 'add';
                    }
                    this.saveHistory();
                    this.showToast('Field removed', 'warning');
                },
                
                addOption() {
                    if (this.selectedField) {
                        const nextNum = this.selectedField.options.length + 1;
                        this.selectedField.options.push('Option ' + nextNum);
                        this.saveHistory();
                    }
                },
                
                removeOption(index) {
                    if (this.selectedField) {
                        this.selectedField.options.splice(index, 1);
                        this.saveHistory();
                    }
                },
                
                updateOption(index, val) {
                    if (this.selectedField) {
                        this.selectedField.options[index] = val;
                        this.persist();
                    }
                },
                
                togglePreview() {
                    this.showPreview = !this.showPreview;
                    this.activeTab = 'editor';
                    if (!this.showPreview) {
                         // re-init sortable when going back to editor
                        this.$nextTick(() => {
                            this.initSortable();
                        });
                    } else {
                        this.selectedFieldId = null;
                    }
                },
                
                showToast(message, type = 'success') {
                    const id = Date.now();
                    this.toasts.push({ id, message, type });
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 3500);
                },
                
                clearForm() {
                    if (confirm('Clear all fields? This can\'t be undone.')) {
                        this.fields = [];
                        this.selectedFieldId = null;
                        this.paletteTab = 'add';
                        this.saveHistory();
                        this.showToast('All fields cleared', 'info');
                    }
                },
                
                exportSchema() {
                    const schema = {
                        title: this.title,
                        submissionUrl: this.submissionUrl,
                        settings: this.formSettings,
                        fields: this.fields.map(f => ({
                            id: f.id,
                            type: f.type,
                            label: f.label,
                            placeholder: f.placeholder || undefined,
                            required: f.required || undefined,
                            min: f.min || undefined,
                            max: f.max || undefined,
                            options: f.options.length ? f.options : undefined,
                            cssClass: f.cssClass || undefined,
                            defaultValue: f.defaultValue || undefined,
                            title: f.title || undefined,
                            description: f.description || undefined
                        }))
                    };
                    
                    console.log('--- Form JSON ---');
                    console.log(JSON.stringify(schema, null, 2));
                    console.log('-----------------------------');
                    
                    // show alert with JSON preview
                    alert('Form JSON generated!\n\nOpen browser console (F12) to see the full output.\n\nPreview:\n' + JSON.stringify(schema, null, 2).substring(0, 300) + '...');
                },
                
                submitPreviewForm() {
                    this.showToast('Form submitted!', 'success');
                    console.log('Submit URL:', this.submissionUrl);
                    console.log('Form data:', JSON.stringify({
                        title: this.title,
                        timestamp: new Date().toISOString(),
                        fields: this.fields.map(f => ({
                            label: f.label,
                            type: f.type,
                            id: f.id
                        }))
                    }, null, 2));
                }
            }));
        });
    </script>
</body>

                    </div>
                </div>
@endsection
