<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search()
    {
        $phrases = [
            number_format(Task::count('id')).' tasks',
            number_format(Comment::count('id')).' task comments',
            number_format(Question::count('id')).' questions',
            number_format(User::count('id')).' users',
            number_format(Product::count('id')).' products',
        ];

        return view('search.search', [
            'random' => $phrases[array_rand($phrases)],
        ]);
    }

    public function tasks(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $tasks = Task::whereHas('user', function ($q) {
                $q->where([
                    ['spammy', false],
                    ['is_private', false],
                ]);
            })
                ->whereHidden(false)
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

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
                    ['spammy', false],
                    ['is_private', false],
                ]);
            })
                ->whereHidden(false)
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

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
            $questions = Question::withCount('answers')
                ->whereHas('user', function ($q) {
                    $q->where([
                        ['spammy', false],
                    ]);
                })
                ->whereHidden(false)
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

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
                    ['spammy', false],
                ]);
            })
                ->whereHidden(false)
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

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
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $products = Product::whereHas('owner', function ($q) {
                $q->where([
                    ['spammy', false],
                ]);
            })
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

            if (count($products) === 0) {
                $products = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'products',
            'searchTerm' => $searchTerm,
            'products' =>  $products,
        ]);
    }

    public function users(Request $request)
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $users = User::search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

            if (count($users) === 0) {
                $users = null;
            }
        } else {
            return redirect()->route('search.home');
        }

        return view('search.result', [
            'type' => 'users',
            'searchTerm' => $searchTerm,
            'users' =>  $users,
        ]);
    }
}
