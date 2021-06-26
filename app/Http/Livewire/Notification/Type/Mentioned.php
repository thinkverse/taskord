<?php

namespace App\Http\Livewire\Notification\Type;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class Mentioned extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render(): View
    {
        if ($this->data['body_type'] === 'task') {
            $body = Task::find($this->data['body_id']);
        } elseif ($this->data['body_type'] === 'comment') {
            $body = Comment::find($this->data['entity_id']);
        } elseif ($this->data['body_type'] === 'comment_reply') {
            $body = CommentReply::find($this->data['entity_id']);
        } elseif ($this->data['body_type'] === 'answer') {
            $body = Answer::find($this->data['entity_id']);
        }

        return view('livewire.notification.type.mentioned', [
            'body' => $body,
        ]);
    }
}
