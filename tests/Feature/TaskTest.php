<?php

use function Tests\actingAs;
use function Pest\Livewire\livewire;

it('has task page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/task/1', 200, false],
    ['/task/1', 200, true],
]);

it('can create task', function () {
    livewire(Counter::class)
        ->call('increment')
        ->assertSee(1);

    // Same as:
    $this->livewire(Counter::class)
        ->call('increment')
        ->assertSee(1);
});
