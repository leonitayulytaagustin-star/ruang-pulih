<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TwoFactorCodeNotification extends Notification
{
    use Queueable;

    protected $code;

    /**
     * Create a new notification instance.
     */
    public function __construct($code)
    {
        $this->code = $code;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Kode Keamanan Autentikasi 2 Langkah - Ruang Pulih')
                    ->greeting('Halo, ' . $notifiable->nama_lengkap)
                    ->line('Seseorang mencoba login ke akun Ruang Pulih Anda.')
                    ->line('Gunakan kode keamanan 4 digit di bawah ini untuk melanjutkan proses login:')
                    ->line('**' . $this->code . '**')
                    ->line('Kode ini akan kedaluwarsa dalam 10 menit.')
                    ->line('Jika Anda tidak merasa melakukan tindakan ini, abaikan email ini atau segera hubungi bantuan.');
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
