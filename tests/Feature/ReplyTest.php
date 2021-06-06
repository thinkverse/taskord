<?php

use App\Http\Livewire\Comment\Reply\CreateReply;
use App\Http\Livewire\Comment\Reply\SingleReply;
use App\Models\Comment;
use App\Models\CommentReply;
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
})->with('model-data');

it('can toggle like on reply', function ($user, $status) {
    $reply = CommentReply::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(SingleReply::class, ['reply' => $reply])
            ->call('toggleLike')
            ->assertEmitted('replyLiked');
    }

    return actingAs($user)
        ->livewire(SingleReply::class, ['reply' => $reply])
        ->call('toggleLike')
        ->assertNotEmitted('replyLiked');
})->with('like-data');
