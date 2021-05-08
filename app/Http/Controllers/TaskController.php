<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function task($id)
    {
        $task = Task::where('id', $id)
            ->firstOrFail();
        $response = [
            'task' => $task,
        ];
        if (
            Auth::check() && auth()->user()->id === $task->user->id or
            Auth::check() && auth()->user()->staffShip
        ) {
            return view('task/task', $response);
        } elseif ($task->user->isFlagged or $task->user->isPrivate) {
            abort(404);
        }

        return view('task/task', $response);
    }

    public function comment($id, $comment_id)
    {
        $task = Task::where('id', $id)
            ->firstOrFail();
        $comment = $task->comments->where('id', $comment_id)->first();
        if (! $comment) {
            abort(404);
        }
        $response = [
            'task' => $task,
            'comment' => $comment,
        ];
        if (
            Auth::check() && auth()->user()->id === $task->user->id or
            Auth::check() && auth()->user()->staffShip
        ) {
            return view('comment/comment', $response);
        } elseif ($task->user->isFlagged or $task->user->isPrivate) {
            abort(404);
        }

        return view('comment/comment', $response);
    }
}
