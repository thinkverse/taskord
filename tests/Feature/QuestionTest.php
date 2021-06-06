<?php

use App\Http\Livewire\Question\CreateQuestion;
use App\Http\Livewire\Question\EditQuestion;
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

it('cannot create question as un-authed user', function () {
    livewire(CreateQuestion::class)
        ->set('title', 'Hello world from test!')
        ->set('body', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
});

it('cannot edit question as un-authed user', function () {
    $question = Question::factory()->create();

    livewire(EditQuestion::class, ['question' => $question])
        ->set('title', 'Hello world from test!')
        ->set('body', 'Hello world from test!')
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
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
})->with('model-content');

it('can edit question as authed user', function ($question, $user, $status) {
    $newQuestion = Question::factory()->create([
        'user_id' => $user,
    ]);

    if ($status) {
        return actingAs($user)
            ->livewire(EditQuestion::class, ['question' => $newQuestion])
            ->set('title', $question)
            ->set('body', $question)
            ->call('submit')
            ->assertEmitted('refreshQuestion');
    }

    return actingAs($user)
        ->livewire(EditQuestion::class, ['question' => $newQuestion])
        ->set('title', $question)
        ->set('body', $question)
        ->call('submit')
        ->assertNotEmitted('refreshQuestion');
})->with('model-content');
