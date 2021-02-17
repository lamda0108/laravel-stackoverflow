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

    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute(){
        // return route("questions.show", $this->id);
        //$question->url
    }

    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
        // return $this->created_at->format("d/m/Y");23/05/2018
        //$question->url
    }

    public function getStatusAttribute(){
        if($this->answers>0){
            if($this->best_answer_id){
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
}
