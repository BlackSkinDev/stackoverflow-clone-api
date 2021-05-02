<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;


class SubscribeController extends Controller
{

    protected $user;

    public function __construct(){
        // get currently authenticated user
        $this->user = JWTAuth::user();

    }

    // subscribe to question
    public function subscribe(Question $question){

        if ($this->isSubscribedToQuestion($this->user,$question->id)){
            return response()->json([
                    'message' => 'You have already subscribed to this question!',
                ], Response::HTTP_OK);
        }

        Subscription::create([
            'user_id'=>$this->user->id,
            'question_id'=>$question->id
        ]);

        return response()->json([
            'message' => 'You have successfully subscribed to  question'
        ], Response::HTTP_OK);
    }



    // check if user is already subscribed to question
    public function isSubscribedToQuestion($user,$question_id){
        $userHasSubscribed= Subscription::where('question_id',$question_id)
            ->where('user_id',$user->id)->count();
        if ($userHasSubscribed){
            return true;
        }
        return false;
    }
}
