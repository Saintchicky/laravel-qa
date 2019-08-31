<?php

namespace App\Http\Controllers;

use App\Question;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Http\Request;


class QuestionsController extends Controller
{
    public function __construct() {
        // Autorise seulement les gens non connecté  à aller sur index et show
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Décompose les requêtes de la méthode
        // \DB::enableQueryLog();
        //Dernière question et change de page toutes les 5 questions 
        $questions = Question::with('user')->latest()->paginate(10);
        return view('questions.index',compact('questions'));
        //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();

        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success',"Your question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
    //en cliquant sur le lien de la question, on va sur la page de celle-ci
    // On ajoute des vues grâce à increment qui se save ds la bdd
       $question->increment('views');
       return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // autorise si L'user id et la même que ds user_id ds questions
        //AuthServiceProvider
        //1ère méthode avec Gate
       /* if(\Gate::denies('update-question',$question)){
            abort(403,"Access Denied");
        }*/
        //2eme méthode avec la class policy 
        $this->authorize("update", $question);
        return view('questions.edit',compact('question'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        $this->authorize("update", $question);
        $question->update($request->only('title','body'));
        return redirect('/questions')->with('success',"Your question has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $this->authorize("delete", $question);
        $question->delete();
        return redirect('/questions')->with('success',"Your question has been deleted");
    }
}
