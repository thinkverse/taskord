<?php

use App\Http\Livewire\Comment\CreateComment;
use App\Http\Livewire\Comment\SingleComment;
use App\Models\Comment;
use App\Models\Task;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has comment page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1/1', 200, false],
    ['/task/1/1', 200, true],
]);

it('cannot create comment as un-authed user', function () {
    $task = Task::factory()->create();

    livewire(CreateComment::class, ['task' => $task])
        ->set('comment', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshComments');
});

it('can create comment as authed user', function ($comment, $user, $status) {
    $task = Task::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(CreateComment::class, ['task' => $task])
            ->set('comment', $comment)
            ->call('submit')
            ->assertEmitted('refreshComments');
    }

    return actingAs($user)
        ->livewire(CreateComment::class, ['task' => $task])
        ->set('task', $task)
        ->call('submit')
        ->assertNotEmitted('refreshComments');
})->with('model-data');

it('can toggle like on comment', function ($user, $status) {
    $comment = Comment::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleComment::class, ['comment' => $comment])
            ->call('toggleLike')
            ->assertEmitted('commentLiked');
    }

    return actingAs($user)
        ->livewire(SingleComment::class, ['comment' => $comment])
        ->call('toggleLike')
        ->assertNotEmitted('commentLiked');
})->with('like-data');
