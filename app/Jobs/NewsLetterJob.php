<?php

namespace App\Jobs;

use App\Mail\SubscriberNewsLetterMail;
use App\Models\SubscriberNotification;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewsLetterJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected object $subscriber;
    protected object $notificationMessage;

    /**
     * Create a new job instance.
     */
    public function __construct(object $subscriber, object $notificationMessage)
    {
        $this->subscriber = $subscriber;
        $this->notificationMessage = $notificationMessage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->subscriber->email)
            ->send(new SubscriberNewsLetterMail(
                    $this->notificationMessage->title,
                    $this->notificationMessage->description
                )
            );

        SubscriberNotification::query()
            ->create([
                'subscriber_id' => $this->subscriber->id,
                'notification_id' => $this->notificationMessage->id,
            ]);
    }
}
