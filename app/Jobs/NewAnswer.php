<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;



class NewAnswer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $question;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($question)
    {
        $this->question=$question;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // notify question subscribers

        $subscribers= $this->question->subscribers();
        $userIds=$subscribers->pluck('id');
        $users=User::find($userIds);
        Notification::send($users, new \App\Notifications\NewAnswer($this->question));

    }
}
