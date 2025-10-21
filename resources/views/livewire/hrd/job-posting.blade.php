<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">{{ $is_edit ? 'Edit' : 'Post' }} Job Vacancy</h1>
        <p class="text-gray-600 mt-2">{{ $is_edit ? 'Update' : 'Create' }} job vacancy for recruitment</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-6">
        <!-- SECTION 1: GENERAL INFORMATION -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">1</span>
                General Information
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Publish Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Publish Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="publish_date" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('publish_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        End Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" wire:model="end_date" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <!-- SECTION 2: VACANCY INFORMATION -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">2</span>
                Vacancy Information
            </h2>

            <div class="space-y-6">
                <!-- Vacancy Title -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Vacancy Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="vacancy_title" 
                        placeholder="e.g., Software Engineer - Backend Developer"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    @error('vacancy_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Position -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Position <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="position" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Position</option>
                            @foreach($positions as $pos)
                                <option value="{{ $pos }}">{{ $pos }}</option>
                            @endforeach
                        </select>
                        @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Education Level -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Education Level <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="education_level" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Education</option>
                            @foreach($education_levels as $edu)
                                <option value="{{ $edu }}">{{ $edu }}</option>
                            @endforeach
                        </select>
                        @error('education_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Function -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Function <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="function" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Function</option>
                            @foreach($functions as $func)
                                <option value="{{ $func }}">{{ $func }}</option>
                            @endforeach
                        </select>
                        @error('function') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Company -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Company <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="company" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select Company</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp }}">{{ $comp }}</option>
                            @endforeach
                        </select>
                        @error('company') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Total Needed -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Total Needed <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="total_needed" min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('total_needed') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Job Description -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Job Description <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="description" rows="6"
                        placeholder="Describe the job responsibilities, requirements, and qualifications..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Skills Required -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Skills Required
                    </label>
                    <div class="flex gap-2 mb-2">
                        <input type="text" wire:model="skills_input" 
                            placeholder="e.g., PHP, Laravel, MySQL"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            wire:keydown.enter.prevent="addSkill">
                        <button type="button" wire:click="addSkill"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add
                        </button>
                    </div>
                    
                    @if(count($skills_required) > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($skills_required as $index => $skill)
                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $skill }}
                                    <button type="button" wire:click="removeSkill({{ $index }})" 
                                        class="ml-2 text-blue-600 hover:text-blue-800">
                                        ×
                                    </button>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- SECTION 3: SELECTION PROCESS TYPE -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm">3</span>
                Selection Process Type
            </h2>

            <div class="space-y-4">
                @foreach($selection_types as $key => $label)
                    <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 {{ $selection_type === $key ? 'border-blue-600 bg-blue-50' : 'border-gray-300' }}">
                        <input type="radio" wire:model="selection_type" value="{{ $key }}" class="mt-1">
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900">{{ $label }}</div>
                            <div class="text-sm text-gray-600 mt-1">
                                @if($key === 'operator_smk')
                                    <div class="space-y-1">
                                        <div>1. Administrative</div>
                                        <div>2. Psychotest</div>
                                        <div>3. User Interview</div>
                                        <div>4. Background Check</div>
                                        <div>5. MCU</div>
                                        <div>6. Offering</div>
                                    </div>
                                @else
                                    <div class="space-y-1">
                                        <div>1. Administrative</div>
                                        <div>2. Psychotest</div>
                                        <div>3. HR Interview</div>
                                        <div>4. User Interview</div>
                                        <div>5. Background Check</div>
                                        <div>6. MCU</div>
                                        <div>7. Offering</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </label>
                @endforeach
                @error('selection_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-wrap gap-3 justify-end">
                <button type="button" wire:click="clearForm"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                    Clear All
                </button>
                <button type="button" wire:click="saveDraft"
                    class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 font-semibold">
                    Save as Draft
                </button>
                <a href="{{ route('hrd.jobs.index') }}"
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold">
                    Close
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                    {{ $is_edit ? 'Update' : 'Submit & Publish' }}
                </button>
            </div>
        </div>
    </form>
</div>
