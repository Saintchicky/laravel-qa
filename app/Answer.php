<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }
    // Eloqent Events
    public static function boot()
    {   
        // On appelle la méthode existante en tant que parent
        parent::boot();
        static::created(function($answer){
            $answer->question->increment('answers_count');
            $answer->question->save();
        });
    }
}
