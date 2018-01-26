<?php

namespace App\Mail;

use App\Client;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $client;

    public function __construct($data)
    {
        //
        //$this->account = $account;
        $this->client = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from($this->client->email)
        ->view('mail.verify')->with([
            'userFirstname' => ucfirst($this->client->firstname). ' '.ucfirst($this->client->lastname),
            'userEmail' => $this->client->email,
            'userPassword' => $this->client->password
        ]);
        
    }
}
