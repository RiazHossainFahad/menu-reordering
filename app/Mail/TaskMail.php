<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\TemplateMailable;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskMail extends TemplateMailable
{
    // use Queueable, SerializesModels;

    public $name;
    public $detail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $detail)
    {
        $this->name = $name;
        $this->detail = $detail;
    }
}