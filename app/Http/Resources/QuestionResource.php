<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'tags' => $this->tags,
            'slug' => $this->slug,
            'created_at' => $this->created_at,
            'user'=>new UserResource($this->user),
            'vote'=>$this->getVote(),
            'answers'=>AnswerResource::collection($this->answers)

        ];
    }
}
