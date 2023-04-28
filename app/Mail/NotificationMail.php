<?php

namespace App\Mail;

use App\Models\Scan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    private Scan $scan;
    private $expression;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Scan $scan, $expression)
    {
        //
        $this->scan = $scan;
        $this->expression = $expression;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@phpuncover.xyz')
            ->view('emails.notification', ['id' => $this->scan->id, 'expression' => $this->expression] );
    }
}
