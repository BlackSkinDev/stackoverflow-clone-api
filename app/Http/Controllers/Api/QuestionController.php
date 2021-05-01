<?php


namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use JWTAuth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    protected $user;

    public function __construct(){
        $this->user = JWTAuth::user();

    }

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

}
