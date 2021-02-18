<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $questions = Question::latest()->paginate(5);
       return view('questions.index')->with([
           'questions'=>$questions
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create')->with([
            'question'=>$question
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title', 'body'));
        return redirect()->route('question.index')->with([
            'success'=>'Your question has been submited'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show')->with([
            'question'=>$question
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // call \Gate::define in AuthServiceProvider, and use it in controller and view
        if(\Gate::denies('update-question', $question)){
            abort(403, 'Access denied');
        }       
        return view("questions.edit")->with([
            'question'=>$question
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        if(\Gate::denies('update-question', $question)){
            abort(403, 'Access denied');
        }   
        $question->update($request->only('title', 'body'));
        return redirect('/question')->with([
            'success'=>'Your question has been updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {   
        if(\Gate::denies('delete-question', $question)){
            abort(403, 'Access denied');
        }   
        $question->delete();
        return redirect('/question')->with([
            'success'=>'Your question has been deleted'
        ]);
    }
}
