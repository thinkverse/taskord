<?php

use App\Http\Livewire\Answer\CreateAnswer;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('cannot create answer as un-authed user', function () {
    $question = Question::factory()->create();

    livewire(CreateAnswer::class, ['question' => $question])
        ->set('answer', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshAnswers');
});

it('can create answer as authed user', function ($answer, $user, $status) {
    $question = Question::factory()->create();

    if ($status) {
        return actingAs($user)
            ->livewire(CreateAnswer::class, ['question' => $question])
            ->set('answer', $answer)
            ->call('submit')
            ->assertEmitted('refreshAnswers');
    }

    return actingAs($user)
        ->livewire(CreateAnswer::class, ['question' => $question])
        ->set('answer', $answer)
        ->call('submit')
        ->assertNotEmitted('refreshAnswers');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
