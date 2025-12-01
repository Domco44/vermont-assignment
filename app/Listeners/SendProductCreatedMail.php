<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Mail\ProductCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendProductCreatedMail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ProductCreated $event): void
    {
        $delayMinutes = (int) config('mail.email_delay_minutes', 15);
        $sendAt = now()->addMinutes($delayMinutes);

        Mail::to(config('mail.admin_address'))
            ->later($sendAt, new ProductCreatedMail($event->product));

    }
}
