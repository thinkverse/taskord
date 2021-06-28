<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function search(): View
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

    public function tasks(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $tasks = Task::with(['user', 'product', 'milestone', 'comments.user', 'oembed'])
                ->whereHas('user', function ($q) {
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

            return view('search.result', [
                'type'       => 'tasks',
                'searchTerm' => $searchTerm,
                'tasks'      => $tasks,
            ]);
        }

        return redirect()->route('search.home');
    }

    public function comments(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $comments = Comment::with(['user', 'task', 'replies'])
                ->whereHas('user', function ($q) {
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

            return view('search.result', [
                'type'       => 'comments',
                'searchTerm' => $searchTerm,
                'comments'   => $comments,
            ]);
        }

        return redirect()->route('search.home');
    }

    public function questions(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $questions = Question::with(['user', 'answers', 'answers.user'])
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

            return view('search.result', [
                'type'       => 'questions',
                'searchTerm' => $searchTerm,
                'questions'  => $questions,
            ]);
        }

        return redirect()->route('search.home');
    }

    public function answers(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $answers = Answer::with(['user', 'question', 'question.user'])
                ->whereHas('user', function ($q) {
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

            return view('search.result', [
                'type'       => 'answers',
                'searchTerm' => $searchTerm,
                'answers'    => $answers,
            ]);
        }

        return redirect()->route('search.home');
    }

    public function products(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $products = Product::with(['user'])
                ->whereHas('user', function ($q) {
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

            return view('search.result', [
                'type'       => 'products',
                'searchTerm' => $searchTerm,
                'products'   => $products,
            ]);
        }

        return redirect()->route('search.home');
    }

    public function users(Request $request): View | RedirectResponse
    {
        $searchTerm = $request->input('q');
        if ($searchTerm) {
            $users = User::with(['followings', 'followers'])
                ->search($searchTerm)
                ->paginate(10)
                ->onEachSide(1);

            if (count($users) === 0) {
                $users = null;
            }

            return view('search.result', [
                'type'       => 'users',
                'searchTerm' => $searchTerm,
                'users'      => $users,
            ]);
        }

        return redirect()->route('search.home');
    }
}
