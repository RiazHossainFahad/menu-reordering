<?php

namespace Database\Seeders;

use App\Models\User;
use App\Mail\TaskMail;
use App\Mail\WelcomeMail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\MailTemplates\Models\MailTemplate;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        MailTemplate::create([
            'mailable' => WelcomeMail::class,
            'subject' => 'Welcome, {{ name }}',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>Thanks for using <strong>{{ app_name }}</strong><p>
            ',
        ]);

        MailTemplate::create([
            'mailable' => TaskMail::class,
            'subject' => 'New Task',
            'html_template' => '
                        <h4>Hello, {{ name }}!</h4>
                        <p>New Task is created for you<p>
                        <p>Details: <strong>{{ detail }}</strong><p>
            ',
        ]);
    }
}