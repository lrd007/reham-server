<?php

namespace App\Jobs;

use App\Mail\EventNotificationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEventNotification implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $email;
    public $event;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $event)
    {
        $this->email = $email;
        $this->event = $event;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Send email to the subscriber
        Mail::to($this->email)->send(new EventNotificationMail($this->event));
    }
}
