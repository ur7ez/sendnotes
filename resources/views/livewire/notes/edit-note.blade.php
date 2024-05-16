<?php

use App\Models\Note;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component {
    public Note $note;

    public $noteTitle;
    public $noteBody;
    public $noteRecipient;
    public $noteSendDate;
    public $noteIsPublished;

    public function mount(Note $note)
    {
        $this->authorize('update', $note);
        $this->fill($note);
        $this->noteTitle = $note->title;
        $this->noteBody = $note->body;
        $this->noteRecipient = $note->recipient;
        $this->noteSendDate = Carbon::parse($note->send_date)->format('Y-m-d');
        $this->noteIsPublished = $note->is_published;
    }

    public function saveNote()
    {
        $validated = $this->validate([
            'noteTitle' => ['required', 'string', 'min:5'],
            'noteBody' => ['required', 'string', 'min:20'],
            'noteRecipient' => ['required', 'email'],
            'noteSendDate' => ['required', 'date'],
        ]);
        $this->note->update([
            'title' => $this->noteTitle,
            'body' => $this->noteBody,
            'recipient' => $this->noteRecipient,
            'send_date' => $this->noteSendDate,
            'is_published' => $this->noteIsPublished,
        ]);

        $this->dispatch('note-saved');
    }
}; ?>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Note') }}
    </h2>
</x-slot>

<div class="py-8">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-3">
        <form wire:submit="saveNote" class="space-y-4">
            <x-input wire:model="noteTitle" label="Note Title" placeholder="great day for me"/>
            <x-textarea wire:model="noteBody" label="Your Note" placeholder="Share all your thoughts with a friend"/>
            <x-input icon="user" type="email" wire:model="noteRecipient" label="Recipient"
                     placeholder="yourfriend@email.com"/>
            <x-input icon="calendar" wire:model="noteSendDate" type="date" label="Send Date"/>
            <x-checkbox wire:model="noteIsPublished" label="Note Published"/>
            <div class="pt-4 flex justify-between">
                <x-button secondary spinner="saveNote" type="submit">Save Note</x-button>
                <x-button href="{{route('notes.index')}}" flat negative>Back to  Notes</x-button>
            </div>
            <x-action-message on="note-saved"/>
            <x-errors/>
        </form>
    </div>
</div>
