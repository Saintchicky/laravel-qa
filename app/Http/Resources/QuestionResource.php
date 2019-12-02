<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

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
       // return parent::toArray($request);
       // on définit les colonnes qui nous intéressent et aussi de la table avec les colonnes qui ns intéressen
       return [
           'id' => $this->id,
           'title' => $this->title,
           'slug' => $this->slug,
           'votes_count' => $this->votes_count,
           'answers_count' => $this->answers_count,
           'views' => $this->views,
           'status' => $this->status,
           'excerpt' =>$this->excerpt,
           'created_date' =>$this->created_date,
           'user' => new UserResource($this->user)

       ];
    }
}
