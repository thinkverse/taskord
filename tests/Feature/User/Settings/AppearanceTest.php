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

// TODO: can edit appearance (toggleMode) settings
