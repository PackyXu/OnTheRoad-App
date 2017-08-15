<?php

namespace App\Http\Controllers;


use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class QuestionFollowController
 * @package App\Http\Controllers
 */
class QuestionFollowController extends Controller
{
    protected $question;
    /**
     * QuestionFollowController constructor.
     */
    public function __construct (QuestionRepository $question) {
        $this->middleware('auth');
        $this->question = $question;
    }

    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function  follow($question)
    {
        Auth::user()->followThis($question);

        return back();
    }

    public function follower (Request $request)
    {
        //return response()->json(['followed'=> false]);
        //$user = Auth::guard('api')->user();
        $followed = user('api')->followed($request->get('question'));

        if ($followed){
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisQuestion (Request $request)
    {
        //$user = Auth::guard('api')->user();
        $question = $this->question->byId($request->get('question'));
        //$followed = $user->follows()->where('question_id',$question->id)->first();
        $followed = user('api')->followThis($question->id);

        if (count($followed['detached']) > 0){
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }


        $question->increment('followers_count');

        return response()->json(['followed' => true]);
    }



}
