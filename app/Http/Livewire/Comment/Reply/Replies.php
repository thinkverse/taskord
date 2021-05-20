<?php

namespace App\Http\Livewire\Comment\Reply;

use App\Models\Comment;
use Livewire\Component;

class Replies extends Component
{
    public Comment $comment;

    public function render()
    {
        return view('livewire.comment.reply.replies');
    }
}
