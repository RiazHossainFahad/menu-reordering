<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\TemplateMailable;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeMail extends TemplateMailable
{
    // use Queueable, SerializesModels;

    public $name;
    public $app_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->name = $user->name;
        $this->app_name = env('APP_NAME');
    }
}