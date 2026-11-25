<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

/** Email tautan reset password untuk akun panel admin (bahasa Indonesia). */
class AdminResetPassword extends ResetPassword
{
    protected function resetUrl($notifiable): string
    {
        return route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }

    public function toMail($notifiable): MailMessage
    {
        $menit = (int) config('auth.passwords.' . config('auth.defaults.passwords') . '.expire', 60);

        return (new MailMessage)
            ->subject('Atur Ulang Password Panel Admin PT PEMA')
            ->greeting('Halo, ' . ($notifiable->name ?: 'Admin') . '!')
            ->line('Kami menerima permintaan untuk mengatur ulang password akun panel admin website PT PEMA Anda.')
            ->action('Atur Ulang Password', $this->resetUrl($notifiable))
            ->line("Tautan ini hanya berlaku selama {$menit} menit dan hanya bisa dipakai satu kali.")
            ->line('Jika Anda tidak meminta pengaturan ulang password, abaikan email ini. Password Anda tidak akan berubah.')
            ->salutation("Salam,\nTim Website PT PEMA");
    }
}
