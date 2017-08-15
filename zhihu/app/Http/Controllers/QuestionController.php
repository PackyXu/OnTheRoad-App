<?php

namespace App\Http\Controllers;

//use App\Question;
use App\Repositories\QuestionRepository;
//use App\Topic;
use Illuminate\Http\Request;
use Auth;

/**
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{
    /**
     * @var QuestionRepository
     */
    protected $questionRepository;

    //查看权限

    /**
     * QuestionController constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct (QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index','show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $questions = $this->questionRepository->getQuestionsFeed();
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->get('topics'));
        //接受问题模块
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));
        //dd($topics);
        //return $request->all();
        //验证数据提交不能为空
        $rules = [
            'title' => 'required|min:6|max:196',
            'body' => 'required|min:26'
        ];
        $this->validate($request,$rules);

        //获取数据
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];

        //存入数据库
        //$question = Question::create($data);
        $question = $this->questionRepository->create($data);
        $question->topics()->attach($topics);

        return redirect()->route('question.show', [$question->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //$question = Question::where('id',$id)->with('topics')->first();

        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);

        return view('questions.show',compact('question'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $question = $this->questionRepository->byId($id);
        if (Auth::user()->owns($question)){
            return view('questions.edit',compact('question'));
        }
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normalizeTopic($request->get('topics'));

        //
        //验证数据提交不能为空
        $rules = [
            'title' => 'required|min:6|max:196',
            'body' => 'required|min:26'
        ];
        $this->validate($request,$rules);



        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);

        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $question = $this->questionRepository->byId($id);

        if (Auth::user()->owns($question)){
            $question->delete();

            return redirect('/');
        }

        abort('403','Forbidden');

    }

    /**
     * @param array $topics
     * @return array
     */
    /*private function normalizeTopic (array $topics) {
        return collect($topics)->map(function($topic){
            if(is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int) $topic;
            }
            $newTopic = Topic::create(['name' => $topic,'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }*/
}
