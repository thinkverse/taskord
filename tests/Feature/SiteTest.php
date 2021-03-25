<?php

use function Tests\actingAs;

it('has keyboard shortcuts skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/shortcuts', 302, false],
    ['/site/shortcuts', 302, true],
]);

it('has ci data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/ci-data', 302, false],
    ['/site/ci-data', 302, true],
]);

it('has deployment data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/deployment-data', 302, false],
    ['/site/deployment-data', 302, true],
]);

it('has commit data details skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/commit-data', 302, false],
    ['/site/commit-data', 302, true],
]);

it('has cache hits skeleton', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/site/cache-hits', 302, false],
    ['/site/cache-hits', 302, true],
]);
