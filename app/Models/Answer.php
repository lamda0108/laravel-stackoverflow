<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'user_id'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
        // return $this->created_at->format("d/m/Y");23/05/2018
        //$question->url
    }

    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
        // Aly, the getBodyHtmlAttribute() method is a Laravel accessor : it creates a property called 
        // body_html in the Question model by converting the value of the body property which is in plain text, to an HTML version of it. 

        // Essentially, in this case, the conversion is about putting every line of text into a paragraph tag.
        //  So instead of having something like "lorem ipsum (...) \n" for every line, as it is stored in the db,
        //   the body_html property (generated by the getHtmlBodyAttribute() method) will give "<p>lorem ipsum</p>".
    }

    // model events
    public static function boot(){
        parent::boot();
        // execute the code when an answer is created
        static::created(function($answer){
           $answer->question->increment('answers_count');
           $answer->question->save();
        });
    }

    public function getStatusAttribute(){
       return $this->isBest()? 'vote-accepted' : '';
    }

    public function getIsBestAttribute(){
        return $this->isBest();
    }

    public function isBest(){
        return $this->id == $this->question->best_answer_id;
    }

}
