<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Cache;

class OtpNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        $otp = $this->generateOtp(); // Custom function to generate OTP
        $this->storeOtpInCache($notifiable, $otp); // Custom function to store OTP in cache

        return (new MailMessage)
            ->line('Your One-Time Password (OTP) is:')
            ->line($otp)
            ->line('This OTP will expire in 10 minutes.')
            ->line('If you did not request this OTP, no further action is required.');
    }

    protected function generateOtp()
    {
        // Implement your logic to generate a random OTP (e.g., using rand() or a package)
        return rand(100000, 999999);
    }

    protected function storeOtpInCache($notifiable, $otp)
    {
        // Store the OTP in cache with a key unique to the user
        Cache::put('otp_' . $notifiable->id, $otp, now()->addMinutes(10));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
