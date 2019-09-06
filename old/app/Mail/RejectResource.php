<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectResource extends Mailable
{
    use Queueable, SerializesModels;
    public $reason;
    public $title;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$reason,$details)
    {
        $this->title = $title;
        $this->reason = $reason;
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@islamicresourcehub.com')
                    ->subject('Your resource has been rejected')
                    ->with([
                        'reason'   =>  $this->reason,
                        'title'    =>  $this->title,
                        'details'  =>  $this->details
                    ])
                    ->markdown('emails.rejectresource');
    }
}
