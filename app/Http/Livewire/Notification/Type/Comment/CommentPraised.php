<?php

namespace App\Http\Livewire\Notification\Type\Comment;

use App\Models\Comment;
use Livewire\Component;

class CommentPraised extends Component
{
    public $data;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $comment = Comment::find($this->data['comment_id']);

        return view('livewire.notification.type.comment.comment-praised', [
            'comment' => $comment,
        ]);
    }
}
