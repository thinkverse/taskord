<?php

use App\Http\Livewire\User\Settings\Api;
use App\Models\User;
use function Tests\actingAs;

it('has settings/api page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/api', 302, false],
    ['/settings/api', 200, true],
]);

it('can edit api (regenerateToken) settings', function () {
    $newUser = User::factory()->create();

    return actingAs($newUser->id)
        ->livewire(Api::class, ['user' => $newUser])
        ->call('regenerateToken')
        ->assertEmitted('refreshApiToken');
});
