<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BundlePurchaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private array $channels;

    public function __construct(array $channels)
    {
        $this->channels = $channels;
    }

    public function via($notifiable): array
    {
        return $this->channels;
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toCassandra($notifiable): CassandraMessage
    {
        return (new CassandraMessage($this->purchase));
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
