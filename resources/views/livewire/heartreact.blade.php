<?php

use App\Models\Note;
use Livewire\Volt\Component;

new class extends Component {
    public Note $note;
    public int $heartCount;

    public function mount(Note $note)
    {
        $this->note = $note;
        $this->heartCount = $note->heart_count;
    }

    public function increaseHeartCount()
    {
        $this->note->update([
            'heart_count' => ++$this->heartCount,
        ]);
        $this->heartCount = $this->note->heart_count;
    }
}; ?>

<div>
    <x-button xs rose icon="heart" wire:click="increaseHeartCount" spinner>{{$heartCount}}</x-button>
</div>
