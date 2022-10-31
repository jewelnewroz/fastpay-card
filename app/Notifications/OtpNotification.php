<?php

namespace App\Notifications;

use App\Message\SmsMessage;
use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Otp $otp;
    private array $channels;

    public function __construct(Otp $otp, $channels = ['mail'])
    {
        $this->otp = $otp;
        $this->channels = $channels;
    }

    public function via($notifiable): array
    {
        return $this->channels;
    }

    public function toSms($notifiable): SmsMessage
    {
        return (new SmsMessage())
            ->to($notifiable->mobile_no)
            ->line('Dear ' . $notifiable->name . ',')
            ->line('Your CardSelling verification OTP is ' . $this->otp->otp);
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
