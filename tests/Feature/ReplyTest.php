<?php

use App\Models\Comment;
use App\Http\Livewire\Comment\Reply\CreateReply;
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

    return actingAs(2)
        ->livewire(CreateReply::class, ['comment' => $comment])
        ->set('reply', $reply)
        ->call('submit')
        ->assertNotEmitted('refreshReplies');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['1234', 2, false],
]);
