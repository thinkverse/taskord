<?php

use function Tests\actingAs;

it('has search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search', 200, false],
    ['/search', 200, true],
]);

it('has tasks search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/tasks?q=hi', 200, false],
    ['/search/tasks?q=hi', 200, true],
]);

it('has comments search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/comments?q=hi', 200, false],
    ['/search/comments?q=hi', 200, true],
]);

it('has questions search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/questions?q=hi', 200, false],
    ['/search/questions?q=hi', 200, true],
]);

it('has answers search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/answers?q=hi', 200, false],
    ['/search/answers?q=hi', 200, true],
]);

it('has products search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/products?q=hi', 200, false],
    ['/search/products?q=hi', 200, true],
]);

it('has users search page', function ($url, $expected, $auth) {
    if ($auth) {
        actingAs(1)->get($url)->assertStatus($expected);
    } else {
        $this->get($url)->assertStatus($expected);
    }
})->with([
    ['/search/users?q=hi', 200, false],
    ['/search/users?q=hi', 200, true],
]);
