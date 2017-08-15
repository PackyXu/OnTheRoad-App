<?php

namespace App\Http\Controllers;


use App\Repositories\TopicRepository;
use Illuminate\Http\Request;

/**
 * Class TopicsController
 * @package App\Http\Controllers
 */
class TopicsController extends Controller
{
    /**
     * @var TopicRepository
     */
    protected $topic;

    /**
     * TopicsController constructor.
     * @param $topic
     */
    public function __construct (TopicRepository $topic) {
        $this->topic = $topic;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index (Request $request)
    {
        return $this->topic->getTopicForTagging($request);
    }
}
