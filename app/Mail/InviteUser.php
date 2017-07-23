<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class InviteUser extends Mailable
{
    use Queueable, SerializesModels;

    public $invite_link;
    public $team;
    public $message;
    public $name;
    public $invitee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite_link, $team, $message, $name, $invitee)
    {
        $this->invite_link = $invite_link;
        $this->team = $team;
        $this->message = $message;
        $this->name = $name;
        $this->invitee = $invitee;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invitation To Etibe Team: ' . $this->team->name)
            ->markdown('email.user.inviteuser');
    }
}
