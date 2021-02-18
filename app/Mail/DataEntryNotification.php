<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DataEntryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $date;
    public $quarter;
    public $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $date, $quarter)
    {
        $this->date = $date;
        $this->name = $name;
        $this->quarter = $quarter;
        $this->link = env('APP_URL') . '/data-entry/?date=' . $date . '&quarter=' . $quarter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.data-entry-notification');
    }
}
