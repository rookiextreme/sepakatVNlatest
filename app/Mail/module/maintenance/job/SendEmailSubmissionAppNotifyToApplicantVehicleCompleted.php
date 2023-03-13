<?php

namespace App\Mail\module\maintenance\job;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailSubmissionAppNotifyToApplicantVehicleCompleted extends Mailable
{
    use Queueable, SerializesModels;
    public $details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->details['subject'])
                    ->view('emails.maintenance.job.submission-app-notify-to-applicant-vehicle-completed');
    }
}
