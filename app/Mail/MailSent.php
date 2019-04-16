<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSent extends Mailable
{
    use Queueable, SerializesModels;
    private $request;

    /**
     * Create a new message instance.
     *
     * @param $request
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->request['email'])
                ->subject($this->request['subject'])
                ->view('contacts::emails.send_mail')
                ->with([
                    'name' => $this->request['name'],
                    'email' => $this->request['email'],
                    'comment' => $this->request['comment']
                    ]);
    }
}
