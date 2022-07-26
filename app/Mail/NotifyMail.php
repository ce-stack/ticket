<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $content;
    public $ticket_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content,$ticket_id)
    {
        $this->content = $content;
        $this->ticket_id = $ticket_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.notify',['content'=>$this->content,'ticket_id'=>$this->ticket_id]);
    }

    public function subject($subject)
    {
        return "Ticket #".$this->ticket_id;
    }
}
