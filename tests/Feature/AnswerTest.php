<?php

use App\Http\Livewire\Answer\AnswerReply;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('cannot create answer as un-authed user', function () {
    $comment = Question::factory()->create();

    livewire(CreateReply::class, ['comment' => $comment])
        ->set('answer', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshComments');
});

it('can create answer as authed user', function ($answer, $user, $status) {
    $comment = Question::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(CreateReply::class, ['comment' => $comment])
            ->set('answer', $reply)
            ->call('submit')
            ->assertEmitted('refreshReplies');
    }

    return actingAs($user)
        ->livewire(CreateReply::class, ['comment' => $comment])
        ->set('reply', $reply)
        ->call('submit')
        ->assertNotEmitted('refreshReplies');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
