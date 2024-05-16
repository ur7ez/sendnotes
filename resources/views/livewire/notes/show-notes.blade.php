<?php

use Livewire\Volt\Component;
use Illuminate\Support\Str;
use App\Models\Note;

new class extends Component {
    public function delete($noteId)
    {
        $note = Note::where('id', $noteId)->first();
        $this->authorize('delete', $note);
        $note->delete();
    }

    public function with(): array
    {
        return [
            'notes' => Auth::user()
                ->notes()
                ->orderBy('send_date', 'desc')
                ->get(),
        ];
    }
}; ?>

<div>
    <div class="space-y-2">
        @if($notes->isEmpty())
            <div class="text-center">
                <p class="text-xl font-bold">No notes yet</p>
                <p class="text-sm">Let's create your first note to send.</p>
                <x-button primary icon-right="plus" class="mt-6" href="{{route('notes.create')}}" wire:navigate>Create
                    note
                </x-button>
            </div>
        @else
            <x-button primary icon-right="plus" class="mb-5" href="{{route('notes.create')}}" wire:navigate>Create new
                note
            </x-button>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 mt-5">
                @foreach($notes as $note)
                    <x-card wire:key="{{$note->id}}" class="flex justify-between flex-col h-100">
                        <div class="flex justify-between">
                            <div>
                                <a href="{{ route('notes.edit', $note) }}" wire:navigate
                                   class="text-xl font-bold hover:underline hover:text-blue-500">{{ Str::limit($note->title, 50) }}</a>
                            </div>
                            <div class="text-xs text-gray-500 ml-2">
                                {{$note->send_date->format('d.M.Y')}}
                            </div>
                        </div>
                        <div class="mt-2 text-sm">{{ Str::limit($note->body, 50) }}</div>

                        <div class="flex items-end justify-between mt-4 space-x-1">
                            <p class="text-xs">Recipient: <span class="font=semibold">{{$note->recipient}}</span></p>
                            <div>
                                <x-button.circle icon="eye"></x-button.circle>
                                <x-button.circle icon="trash" wire:click="delete('{{$note->id}}')"></x-button.circle>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</div>
