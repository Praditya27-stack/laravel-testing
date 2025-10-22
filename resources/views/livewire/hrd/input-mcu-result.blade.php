<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Input MCU Result</h1>
            <p class="mt-1 text-sm text-gray-600">Input medical checkup results for {{ $application->user->name }}</p>
        </div>
        <a href="{{ route('hrd.medical-checkup.status') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
            ← Back to Status
        </a>
    </div>

    <!-- Candidate Info -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Candidate Information</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600">Name</p>
                <p class="font-semibold">{{ $application->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Position</p>
                <p class="font-semibold">{{ $application->job->vacancy_title ?? $application->job->title }}</p>
            </div>
            @if($schedule)
            <div>
                <p class="text-sm text-gray-600">MCU Date</p>
                <p class="font-semibold">{{ $schedule->mcu_date->format('d M Y') }} at {{ $schedule->mcu_time }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Clinic</p>
                <p class="font-semibold">{{ $schedule->clinic->name }}</p>
            </div>
            @endif
        </div>
    </div>

    <form wire:submit.prevent="saveResult">
        <!-- File Upload -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Upload MCU Result (PDF)</h2>
            <input type="file" wire:model="resultFile" accept=".pdf" class="w-full px-4 py-2 border rounded-lg">
            @error('resultFile') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            
            @if($resultFile)
                <p class="mt-2 text-sm text-green-600">✓ File selected: {{ $resultFile->getClientOriginalName() }}</p>
            @endif
        </div>

        <!-- Vital Signs -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Vital Signs</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Blood Pressure</label>
                    <input type="text" wire:model="blood_pressure" placeholder="120/80" class="w-full px-4 py-2 border rounded-lg">
                    @error('blood_pressure') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Heart Rate (BPM)</label>
                    <input type="number" wire:model="heart_rate" placeholder="72" class="w-full px-4 py-2 border rounded-lg">
                    @error('heart_rate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Body Temperature (°C)</label>
                    <input type="number" step="0.1" wire:model="body_temperature" placeholder="36.5" class="w-full px-4 py-2 border rounded-lg">
                    @error('body_temperature') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                    <input type="number" step="0.1" wire:model.blur="height" placeholder="170" class="w-full px-4 py-2 border rounded-lg">
                    @error('height') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                    <input type="number" step="0.1" wire:model.blur="weight" placeholder="65" class="w-full px-4 py-2 border rounded-lg">
                    @error('weight') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">BMI</label>
                    <input type="text" wire:model="bmi" readonly class="w-full px-4 py-2 border rounded-lg bg-gray-100">
                    @if($bmi)
                        <p class="mt-1 text-xs text-gray-500">
                            @if($bmi < 18.5) Underweight
                            @elseif($bmi < 25) Normal
                            @elseif($bmi < 30) Overweight
                            @else Obese
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Vision & Hearing -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Vision & Hearing Test</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vision Left Eye</label>
                    <input type="text" wire:model="vision_left" placeholder="6/6 or 20/20" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vision Right Eye</label>
                    <input type="text" wire:model="vision_right" placeholder="6/6 or 20/20" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hearing Test</label>
                    <select wire:model="hearing_test" class="w-full px-4 py-2 border rounded-lg">
                        <option value="">-- Select --</option>
                        <option value="pass">Pass</option>
                        <option value="fail">Fail</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Lab Tests -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Laboratory Tests</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Blood Test Results</label>
                    <textarea wire:model="blood_test_results" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter blood test results..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Urine Test Results</label>
                    <textarea wire:model="urine_test_results" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Enter urine test results..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">X-Ray Result</label>
                    <input type="text" wire:model="xray_result" placeholder="Normal/Abnormal" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">X-Ray Notes</label>
                    <textarea wire:model="xray_notes" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Additional notes..."></textarea>
                </div>
            </div>
        </div>

        <!-- Overall Assessment -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Overall Assessment</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Overall Fitness <span class="text-red-500">*</span></label>
                    <select wire:model="overall_fitness" class="w-full px-4 py-2 border rounded-lg">
                        <option value="pending">Pending</option>
                        <option value="fit">Fit for Work</option>
                        <option value="unfit">Unfit</option>
                        <option value="need_retest">Need Retest</option>
                    </select>
                    @error('overall_fitness') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Medical Notes</label>
                    <textarea wire:model="medical_notes" rows="3" class="w-full px-4 py-2 border rounded-lg" placeholder="Add medical notes or observations..."></textarea>
                </div>

                @if($overall_fitness === 'unfit')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unfit Reason <span class="text-red-500">*</span></label>
                    <textarea wire:model="unfit_reason" rows="2" class="w-full px-4 py-2 border rounded-lg" placeholder="Specify reason for unfit status..."></textarea>
                    @error('unfit_reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                @endif
            </div>
        </div>

        <!-- Final Decision -->
        <div class="bg-yellow-50 rounded-lg shadow p-6 border-l-4 border-yellow-400">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Final Decision <span class="text-red-500">*</span></h2>
            <div class="space-y-3">
                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-yellow-100" :class="{'border-green-500 bg-green-50': $wire.result === 'fit'}">
                    <input type="radio" wire:model="result" value="fit" class="mr-3">
                    <div>
                        <p class="font-semibold text-green-700">✓ FIT - Pass MCU</p>
                        <p class="text-sm text-gray-600">Candidate will move to Hiring Approval stage</p>
                    </div>
                </label>

                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-yellow-100" :class="{'border-red-500 bg-red-50': $wire.result === 'unfit'}">
                    <input type="radio" wire:model="result" value="unfit" class="mr-3">
                    <div>
                        <p class="font-semibold text-red-700">✗ UNFIT - Fail MCU</p>
                        <p class="text-sm text-gray-600">Application will be rejected</p>
                    </div>
                </label>

                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-yellow-100" :class="{'border-orange-500 bg-orange-50': $wire.result === 'need_retest'}">
                    <input type="radio" wire:model="result" value="need_retest" class="mr-3">
                    <div>
                        <p class="font-semibold text-orange-700">⏳ NEED RETEST</p>
                        <p class="text-sm text-gray-600">Schedule retest for candidate</p>
                    </div>
                </label>

                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-yellow-100" :class="{'border-gray-500 bg-gray-50': $wire.result === 'pending'}">
                    <input type="radio" wire:model="result" value="pending" class="mr-3">
                    <div>
                        <p class="font-semibold text-gray-700">⏸ PENDING</p>
                        <p class="text-sm text-gray-600">Save without final decision</p>
                    </div>
                </label>
            </div>
            @error('result') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3">
            <a href="{{ route('hrd.medical-checkup.status') }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Save MCU Result
            </button>
        </div>
    </form>
</div>
