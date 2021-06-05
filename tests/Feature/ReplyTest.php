<?php

use App\Models\Task;
use App\Http\Livewire\Comment\CreateComment;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

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

    return actingAs(2)
        ->livewire(CreateComment::class, ['task' => $task])
        ->set('task', $task)
        ->call('submit')
        ->assertNotEmitted('refreshComments');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['1234', 2, false],
]);
