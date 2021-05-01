<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Models\Question;
use JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    protected $user;

    public function __construct(){
        $this->user = JWTAuth::user();
    }


    public function reply(AnswerRequest $request, Question $question){
        $this->user->answers()->create([
            'answer'=>$request['answer'],
            'question_id'=>$question->id
        ]);
        return response()->json([
            'message' => 'Answer saved successfully'
        ], Response::HTTP_OK);
    }


}
