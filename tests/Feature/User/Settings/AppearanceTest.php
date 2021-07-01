<?php

use App\Http\Livewire\User\Settings\Appearance;
use App\Models\User;
use function Tests\actingAs;

it('has settings/appearance page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/appearance', 302, false],
    ['/settings/appearance', 200, true],
]);

it('can edit appearance (toggleMode) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Appearance::class, ['user' => $newUser])
        ->call('toggleMode', 'light')
        ->assertEmitted('toggledMode');
});
