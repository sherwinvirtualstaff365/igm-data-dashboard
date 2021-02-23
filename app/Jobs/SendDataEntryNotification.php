<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Mail;
use App\Mail\DataEntryNotification;

class SendDataEntryNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $date;
    private $quarter;
    private $receipients = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($date, $quarter)
    {
        $this->date = $date;
        $this->quarter = $quarter;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = \App\Models\User::where('type', 'staff')->get();
        foreach ($users as $u) {
            \Log::debug('sending notification to '.$u->email);
            Mail::to($u->email)->queue(new DataEntryNotification($u->name, $this->date, $this->quarter));
        }
    }
}
