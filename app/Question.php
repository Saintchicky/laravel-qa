<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VoteTableTrait;

    protected $fillable = ['title', 'body'];
    // Déclarer appends pour utiliser les accessors ds vueJs
    protected $appends = ['created_date','is_favorited','favorites_count','body_html'];
    public function user() {
        return $this->belongsTo(User::class);
    }    
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
    // 2ème façon clean avant envoi bdd
    // public function setBodyAttribute($value)
    // {
    //     // clean ac purifer
    //     $this->attributes['body'] = clean($value);
    // }
    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
    public function getBodyHtmlAttribute()
    {
        // Clean = composer purifier
        return clean($this->bodyHtml());
    }
    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
        // $question->answers->count()
        // foreach ($question->answers as $answer)
    }
    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }
    public function favorites()
    {
        //Ajoute le date created
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id');
    }
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }
    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()),$length);
    }
    private function bodyHtml()
    {
        return clean(\Parsedown::instance()->text($this->body));
    }
}
