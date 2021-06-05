<?php

use App\Http\Livewire\Comment\Reply\CreateReply;
use App\Models\Comment;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('cannot create reply as un-authed user', function () {
    $comment = Comment::factory()->create();

    livewire(CreateReply::class, ['comment' => $comment])
        ->set('reply', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshComments');
});

it('can create reply as authed user', function ($reply, $user, $status) {
    $comment = Comment::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(CreateReply::class, ['comment' => $comment])
            ->set('reply', $reply)
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