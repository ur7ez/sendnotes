<?php

namespace App\Jobs;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Note $note)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $noteUrl = route('notes.view', ['note' => $this->note->id]);  // url('/notes/' . $this->note->id);
        $emailContent = "Hello, you've received a new note. View it here: {$noteUrl}";
        Mail::raw($emailContent, function ($msg) {
            $msg
                ->from('sendnotes@test.com', config('app.name'))
                ->to($this->note->recipient)
                ->subject('You have a new note from ' . $this->note->user->name);
        });
    }
}
