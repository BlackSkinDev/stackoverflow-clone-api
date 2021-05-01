<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\Vote;
use JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    protected $user;

    public function __construct(){
        // get currently authenticated user
        $this->user = JWTAuth::user();

    }

    // store/ask question
    public function store(QuestionRequest $request){
         $this->user->questions()->create([
            'title'=>$request['title'],
            'body'=>$request['body'],
            'tags'=>$request['title'],
            'slug'=>Str::slug($request['title'], '-')
        ]);
        return response()->json([
            'message' => 'Question saved successfully'
        ], Response::HTTP_OK);
    }

    // upvote question
    public function upvote(Question $question){

        if ($this->hasVote($this->user,$question->id)){

            $vote=Vote::where('question_id',$question->id)
                ->where('user_id',$this->user->id)->first();
            $status=$vote->status;

            if ($status){
                return response()->json([
                    'message' => 'You have already upvoted this question!',
                ], Response::HTTP_OK);
            }

            // upvote
            $vote->increment('status');
            return response()->json([
                'message' => 'You just upvoted this question!',
            ], Response::HTTP_OK);


        }

        Vote::create([
           'question_id'=>$question->id,
            'user_id'=>$this->user->id,
            'status'=>1
        ]);
        return response()->json([
            'message' => 'You just upvoted question'
        ], Response::HTTP_OK);
    }


    //downvote question
    public function downvote(Question $question){
        if ($this->hasVote($this->user,$question->id)){

            $vote=Vote::where('question_id',$question->id)
                ->where('user_id',$this->user->id)->first();
            $status=$vote->status;

            if (!$status){
                return response()->json([
                    'message' => 'You have already downvoted this question!',
                ], Response::HTTP_OK);
            }

            // downvote
            $vote->decrement('status');
            return response()->json([
                'message' => 'You just downvoted this question!',
            ], Response::HTTP_OK);

        }

        Vote::create([
            'question_id'=>$question->id,
            'user_id'=>$this->user->id,
            'status'=>0
        ]);
        return response()->json([
            'message' => 'You just downvoted question'
        ], Response::HTTP_OK);
    }


    // function to check if user has either upvoted/downvoted question
    public function hasVote($user,$question_id){
        $userHasVote= Vote::where('question_id',$question_id)
            ->where('user_id',$user->id)->count();
        if ($userHasVote){
            return true;
        }
        return false;
    }


    // function to show  question
    public function show($question){


        $question=Question::where('id',$question)->with('answers')->first();

        return response()->json([
            'question' => new QuestionResource($question),
        ], Response::HTTP_OK);

    }


}
