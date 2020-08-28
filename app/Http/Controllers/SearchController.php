<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        return view('search.search');
    }

    public function tasks(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $tasks = Task::whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                    ['isPrivate', false],
                ]);
            })
                ->where('task', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($tasks) === 0) {
                $tasks = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'tasks',
            'searchTerm' => $searchTerm,
            'tasks' =>  $tasks,
        ]);
    }

    public function comments(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $comments = Comment::whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                    ['isPrivate', false],
                ]);
            })
                ->where('comment', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($comments) === 0) {
                $comments = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'comments',
            'searchTerm' => $searchTerm,
            'comments' =>  $comments,
        ]);
    }

    public function questions(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $questions = Question::whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
                ->where('title', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($questions) === 0) {
                $questions = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'questions',
            'searchTerm' => $searchTerm,
            'questions' =>  $questions,
        ]);
    }

    public function answers(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $answers = Answer::whereHas('user', function ($q) {
                $q->where([
                    ['isFlagged', false],
                ]);
            })
                ->where('answer', 'LIKE', '%'.$searchTerm.'%')
                ->paginate(10);
            if (count($answers) === 0) {
                $answers = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'answers',
            'searchTerm' => $searchTerm,
            'answers' =>  $answers,
        ]);
    }

    public function products(Request $request)
    {
    }

    public function users(Request $request)
    {
    }
}
