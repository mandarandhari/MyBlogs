<?php

namespace App\Mail;

use App\ForgotPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $forgot_password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ForgotPassword $forgot_password)
    {
        $this->forgot_password = $forgot_password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@myblogs.com')
                    ->view('emails.forgot_password')
                    ->with([
                        'token' => $this->forgot_password->token
                    ]);
    }
}
