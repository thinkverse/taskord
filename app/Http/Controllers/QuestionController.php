<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends Controller
{
    public function newest()
    {
        return view('question.questions', [
            'type' => 'questions.newest',
        ]);
    }

    public function unanswered()
    {
        return view('question.questions', [
            'type' => 'questions.unanswered',
        ]);
    }

    public function popular()
    {
        return view('question.questions', [
            'type' => 'questions.popular',
        ]);
    }

    public function question($id)
    {
        $question = Question::where('id', $id)->firstOrFail();
        $response = [
            'type' => 'question.question',
            'question' => $question,
        ];

        if (
            auth()->check() && auth()->user()->id === $question->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            views($question)->record();

            return view('question.question', $response);
        } elseif (auth()->check() && $question->patronOnly) {
            if (auth()->check() && ! auth()->user()->isPatron) {
                return redirect()->route('patron.home');
            } else {
                views($question)->record();

                return view('question.question', $response);
            }
        } elseif ($question->user->isFlagged) {
            abort(404);
        }

        if ($question->patronOnly) {
            return redirect()->route('patron.home');
        } else {
            return view('question.question', $response);
        }
    }

    public function edit(Question $question)
    {
        if (
            auth()->check() && auth()->user()->id === $question->user->id or
            auth()->check() && auth()->user()->staff_mode
        ) {
            return view('question.edit', [
                'question' => $question,
            ]);
        } else {
            abort(404);
        }
    }
}
