<?php

namespace Tests\Feature;

use App\Http\Livewire\Task\CreateComment;
use App\Http\Livewire\Task\SingleComment;
use App\Models\Comment;
use App\Models\Task;
use App\Models\User;
use Livewire;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_create_comment()
    {
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_create_comment()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', md5(microtime()))
            ->call('submit')
            ->assertSeeHtml('Comment has been added!');
    }

    public function test_auth_create_comment_profanity()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->set('comment', 'Bitch')
            ->call('submit')
            ->assertHasErrors([
                'comment' => 'profanity',
            ])
            ->assertSeeHtml('Please check your words!');
    }

    public function test_auth_create_comment_required()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task = Task::create([
            'user_id' => 1,
            'task' => md5(microtime()),
            'done' => true,
        ]);

        Livewire::test(CreateComment::class, ['task' => $task])
            ->call('submit')
            ->assertHasErrors([
                'comment' => 'required',
            ])
            ->assertSeeHtml('The comment field is required.');
    }

    public function test_praise_comment()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task_comment = Comment::create([
            'user_id' =>  $user->id,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $task_comment])
            ->call('togglePraise')
            ->assertSeeHtml('You can&#039;t praise your own comment!');
    }

    public function test_praise_others_task_comment()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task_comment = Comment::create([
            'user_id' =>  2,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $task_comment])
            ->call('togglePraise')
            ->assertDontSeeHtml('You can&#039;t praise your own comment!');
    }

    public function test_delete_task_comment()
    {
        $task_comment = Comment::create([
            'user_id' =>  1,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $task_comment])
            ->call('deleteComment')
            ->assertSeeHtml('Forbidden!');
    }

    public function test_auth_delete_task_comment()
    {
        $user = User::where(['email' => 'test@taskord.com'])->first();
        $this->actingAs($user);
        $task_comment = Comment::create([
            'user_id' =>  $user->id,
            'task_id' =>  1,
            'comment' => md5(microtime()),
        ]);

        Livewire::test(SingleComment::class, ['comment' => $task_comment])
            ->call('deleteComment')
            ->assertEmitted('commentDeleted');
    }
}
