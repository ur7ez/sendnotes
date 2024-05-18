<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;
use Carbon\Carbon;

new class extends Component {
    public function with()
    {
        $notes = Auth::user()->notes();
        $now = Carbon::now()->toDateString();
        return [
            'notesSentCount' => $notes
                ->where('is_published', true)
                ->whereDate('send_date', '<', $now)
                ->count(),
            'notesLovedCount' => $notes->sum('heart_count'),
        ];
    }
}; ?>

<div>
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-2 md:grid-cols-2">
        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Notes Sent</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $notesSentCount }}</p>
            </div>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <div class="flex items-center">
                <div>
                    <p class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">Notes Loved</p>
                </div>
            </div>
            <div class="mt-6">
                <p class="text-3xl font-bold leading-9 text-gray-900 dark:text-gray-100">{{ $notesLovedCount }}</p>
            </div>
        </div>
    </div>
</div>
