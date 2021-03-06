<?php

use function Tests\actingAs;

it('has explore page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/explore', 200, false],
    ['/explore', 200, true],
]);
