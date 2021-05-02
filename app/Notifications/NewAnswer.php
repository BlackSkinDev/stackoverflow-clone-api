<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAnswer extends Notification
{
    use Queueable;


    public $question;


    public function __construct($question)
    {
        $this->question=$question;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    // send question title along with the notification
    public function toArray($notifiable)
    {
        return [
            "question"=>$this->question->title
        ];
    }
}
