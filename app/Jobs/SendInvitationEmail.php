<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\InviteUser;
use Mail;

class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $invite_link;
    protected $team;
    protected $message;
    protected $name;
    protected $invitee;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $invite_link, $team, $message, $name, $invitee)
    {
        $this->email = $email;
        $this->invite_link = $invite_link;
        $this->team = $team;
        $this->message = $message;
        $this->name = $name;
        $this->invitee = $invitee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)
            ->queue(new InviteUser(
                $this->invite_link, 
                $this->team,
                $this->message,
                $this->name,
                $this->invitee
            )
        );
    }
}
