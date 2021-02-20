<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body'];

    public function user(){
        return $this->belongsTo(User::class);
        //$question = Question::find(1);
        //$question->user->name
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute(){
         return route("question.show", $this->slug);
        //$question->url
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
        // return $this->created_at->format("d/m/Y");23/05/2018
        //$question->url
    }

    public function getStatusAttribute(){
        if($this->answers_count>0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
        // Aly, the getBodyHtmlAttribute() method is a Laravel accessor : it creates a property called 
        // body_html in the Question model by converting the value of the body property which is in plain text, to an HTML version of it. 

        // Essentially, in this case, the conversion is about putting every line of text into a paragraph tag.
        //  So instead of having something like "lorem ipsum (...) \n" for every line, as it is stored in the db,
        //   the body_html property (generated by the getHtmlBodyAttribute() method) will give "<p>lorem ipsum</p>".
    }

    public function acceptBestAnswer(Answer $answer){
        $this->best_answer_id = $answer->id;
        $this->save();
    }
}

