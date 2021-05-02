<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Jobs\NewAnswer;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class AnswerController extends Controller
{
    protected $user;

    public function __construct(){
        //get currently authenticated user
        $this->user = JWTAuth::user();
    }

    // answer a question
    public function reply(AnswerRequest $request, Question $question){

        $this->user->answers()->create([
            'answer'=>$request['answer'],
            'question_id'=>$question->id
        ]);

        NewAnswer::dispatch($question);
        return response()->json([
            'message' => 'Answer saved'
        ], Response::HTTP_OK);
    }

    // upvote answer
    public function upvote(Answer $answer){

        if ($this->hasVote($this->user,$answer->id)){

            $vote=Vote::where('answer_id',$answer->id)
                ->where('user_id',$this->user->id)->first();
            $status=$vote->status;


            if ($status){
                return response()->json([
                    'message' => 'You have already upvoted this answer!',
                ], Response::HTTP_OK);
            }

            // upvote
            $vote->increment('status');
            return response()->json([
                'message' => 'You just upvoted this answer!',
            ], Response::HTTP_OK);


        }

        Vote::create([
            'answer_id'=>$answer->id,
            'user_id'=>$this->user->id,
            'status'=>1
        ]);
        return response()->json([
            'message' => 'You just upvoted answer'
        ], Response::HTTP_OK);
    }

    //downvote answer
    public function downvote(Answer $answer){

        if ($this->hasVote($this->user,$answer->id)){

            $vote=Vote::where('answer_id',$answer->id)
                ->where('user_id',$this->user->id)->first();
            $status=$vote->status;

            if (!$status){
                return response()->json([
                    'message' => 'You have already downvoted this answer!',
                ], Response::HTTP_OK);
            }

            // downvote
            $vote->decrement('status');
            return response()->json([
                'message' => 'You just downvoted this answer!',
            ], Response::HTTP_OK);

        }

        Vote::create([
            'question_id'=>$answer->id,
            'user_id'=>$this->user->id,
            'status'=>0
        ]);
        return response()->json([
            'message' => 'You just downvoted answer'
        ], Response::HTTP_OK);
    }

    // function to check if user has either upvoted/downvoted an answer
    public function hasVote($user,$answer_id){
        $userHasVote= Vote::where('answer_id',$answer_id)
            ->where('user_id',$user->id)->count();
        if ($userHasVote){
            return true;
        }
        return false;
    }



}
