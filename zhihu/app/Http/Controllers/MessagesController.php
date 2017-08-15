<?php

namespace App\Http\Controllers;

use App\Repositories\MessageRepository;
use Illuminate\Http\Request;


class MessagesController extends Controller
{
    protected $message;

    /**
     * MessagesController constructor.
     * @param $message
     */
    public function __construct (MessageRepository $message) {
        $this->message = $message;
    }

    public function store ()
    {
        //验证数据提交不能为空
        /*$rules = [
            'msg_content' => 'required|min:6'
        ];
        $this->validate($request,$rules);*/

        $messages = $this->message->create([
           'to_user_id' => \request('user'),
           'from_user_id'=> user('api')->id,
           'msg_content' => \request('msg_content'),
           'dialog_id' => \request('dialog_id'),
        ]);

        if ($messages) {
            return response()->json(['status' => true]);
        }

        return response()->json(['status' => false]);

    }





}
