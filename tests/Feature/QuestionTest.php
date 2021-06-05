<?php

use App\Http\Livewire\Question\CreateQuestion;
use App\Models\Question;
use function Pest\Livewire\livewire;
use function Tests\actingAs;

it('has questions page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/questions', 200, false],
    ['/questions', 200, true],
]);

it('has new question page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/questions/new', 302, false],
    ['/questions/new', 200, true],
]);

it('has single question page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/question/1', 200, false],
    ['/question/1', 200, true],
]);

it('cannot create task as un-authed user', function () {
    livewire(CreateQuestion::class)
        ->set('title', 'Hello world from test!')
        ->set('body', 'Hello world from test!')
        ->call('submit')
        ->assertDispatchedBrowserEvent('toast', [
            'type' => 'error',
            'body' => config('taskord.error.deny'),
        ]);
});

it('can create question as authed user', function ($question, $user, $status) {
    if ($status) {
        return actingAs($user)
            ->livewire(CreateQuestion::class)
            ->set('title', $question)
            ->set('body', $question)
            ->call('submit')
            ->assertEmitted('refreshQuestion');
    }

    return actingAs($user)
        ->livewire(CreateQuestion::class)
        ->set('title', $question)
        ->set('body', $question)
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
})->with([
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
