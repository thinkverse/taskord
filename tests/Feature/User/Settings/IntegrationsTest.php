<?php

use App\Models\Webhook;
use function Tests\actingAs;

it('has settings/integrations page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/settings/integrations', 302, false],
    ['/settings/integrations', 200, true],
]);

// TODO: can create new webhook
// TODO: can delete a webhook
