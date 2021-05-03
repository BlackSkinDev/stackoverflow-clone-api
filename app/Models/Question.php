<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;



class Question extends Model
{
    use HasFactory;
    protected $guarded=[];

    public  function  answers(){
        return $this->HasMany(Answer::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }


    public function getVote(){
        return Vote::where('question_id',$this->id)
            ->where('status',1)->count();
    }

    public  function subscribers(){
        //return $this->hasMany(Subscription::class)->join('users','users.id','=','subscriptions.user_id')->select('users.*');

        return DB::table('users')
         ->join('subscriptions','users.id','=','subscriptions.user_id')
         ->join('questions','questions.id','=','subscriptions.question_id')
         ->where('questions.id','=',$this->id)
         ->where('subscriptions.status','=',1)
            ->select('users.*')->get();
    }
}
