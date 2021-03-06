<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Question;

class VoteQuestionController extends Controller
{
    public function __invoke(Question $question)
    {
        $vote = (int) request()->vote;
        $votesCount = auth()->user()->voteQuestion($question, $vote);
        return response()->json([
            'message' => 'Thanks for the feedback',
            'votesCount' => $votesCount
        ]);
    }
}
