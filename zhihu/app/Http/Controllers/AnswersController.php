<?php
namespace App\Http\Controllers;


use App\Http\Requests\StoreAnswerRequest;
use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Auth;


/**
 * Class AnswersController
 * @package App\Http\Controllers
 */
class AnswersController extends Controller
{
    /**
     * @var AnswerRepository
     */
    protected $answer;

    /**
     * AnswersController constructor.
     * @param AnswerRepository $answer
     */
    public function __construct (AnswerRepository  $answer) {
        $this->answer = $answer;
    }





    /**
     * @param Request $request
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store (StoreAnswerRequest $request,$question)
    {
        //dd($request->all());
        $answer = $this->answer->create([
            'question_id' => $question,
            'user_id' => Auth::id(),
            'body' => $request->get('body')
        ]);
        //dd($answer);
        $answer->question()->increment('answers_count');

        return back();
        //dd($request->all());
    }
}
