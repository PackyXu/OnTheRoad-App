<?php

namespace App\Http\Controllers;

use App\Repositories\AnswerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VotesController extends Controller
{
    protected $answer;

    /**
     * VotesController constructor.
     * @param $answer
     */
    public function __construct (AnswerRepository $answer) { $this->answer = $answer; }

    //
    public function users ($id)
    {
        //$user = Auth::guard('api')->user();

        if (user('api')->hasVoteFor($id)){
            return response()->json(['voted'=> true]);
        }

        return response()->json(['voted'=> false]);

    }

    public function vote ()
    {
        $answer = $this->answer->byId(\request('answer'));

        $voted = user('api')->voteFor(\request('answer'));

        if (count($voted['attached']) > 0){

            $answer->increment('votes_count');

            return response()->json(['voted' => true]);
        }

        $answer->decrement('votes_count');

        return response()->json(['voted' => false]);
    }
}
