<?php

namespace Tests\Unit;

use App\Helpers\Helper;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\assertMatchesRegularExpression;

it('can convert to CDN url in production enviroment with arguments', function ($url, $resolution, $expected) {
    App::shouldReceive('environment')->once()->withNoArgs()->andReturn('production');

    expect(Helper::getCDNImage($url, $resolution))->toEqual($expected);
})->with([
    ['https://taskord.com/storage/test.webp', 500, 'https://ik.imagekit.io/taskordimg/tr:w-500/test.webp'],
    ['https://taskord.com/storage/test.webp', 501, 'https://ik.imagekit.io/taskordimg/tr:w-501/test.webp'],
]);

it('can convert to CDN url in production enviroment without arguments', function () {
    App::shouldReceive('environment')->once()->withNoArgs()->andReturn('production');

    $urlFromHelper = Helper::getCDNImage('https://taskord.com/storage/test.webp');

    expect($urlFromHelper)->toEqual('https://ik.imagekit.io/taskordimg/tr:w-500/test.webp');
});

it('can get correct usernames from mentions', function ($text, $expected) {
    $usernames = Helper::getUsernamesFromMentions($text);

    expect($usernames)->toMatchArray($expected);
})->with([
    ['Hello @test and @admin', ['test', 'admin']],
    ['@test @adm_in', ['test', 'adm_in']],
    ['@test @admin', ['test', 'admin']],
    ['Hello @te-st', ['te-st']],
    ['@te-st', ['te-st']],
    ['@test', ['test']],
]);

it('can return empty array if no user mentions are found', function () {
    $usernames = Helper::getUsernamesFromMentions('no users found');

    expect($usernames)->toBeEmpty();
});

it('can parse mentions to markdown', function (
    string $markdown,
    array $mentions,
    string $expected
) {
    $parsed = Helper::parseUserMentionsToMarkdownLinks($markdown, $mentions);

    expect($parsed)->toEqual($expected);
})->with([
    ['@test @ad_min', ['ad_min', 'test'], '[@test](/@test) [@ad_min](/@ad_min)'],
    ['@test @admin', ['test', 'admin'], '[@test](/@test) [@admin](/@admin)'],
    ['@test @admin', ['test'], '[@test](/@test) @admin'],
    ['Hello @test', ['test'], 'Hello [@test](/@test)'],
    ['@ad_min', ['ad_min'], '[@ad_min](/@ad_min)'],
    ['@te-st', ['te-st'], '[@te-st](/@te-st)'],
    ['@test', ['test'], '[@test](/@test)'],
]);

// it('can return empty array if no product mentions are found', function () {
//     $products = Helper::getProductIDFromMention('no users found');

//     expect($products)->toBeEmpty();
// });

it('can render task with user mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['@test @admin', '<a href="/@test">@test</a> <a href="/@admin">@admin</a>'],
    ['@test admin', '<a href="/@test">@test</a> admin'],
    ['Hello @test', 'Hello <a href="/@test">@test</a>'],
    ['@te_st', '<a href="/@te_st">@te_st</a>'],
    ['@te-st', '<a href="/@te-st">@te-st</a>'],
    ['@test', '<a href="/@test">@test</a>'],
]);

it('can render task with product mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['#test #admin', '<a href="/product/test">#test</a> <a href="/product/admin">#admin</a>'],
    ['#test admin', '<a href="/product/test">#test</a> admin'],
    ['Hello #test', 'Hello <a href="/product/test">#test</a>'],
    ['#te_st', '<a href="/product/te_st">#te_st</a>'],
    ['#te-st', '<a href="/product/te-st">#te-st</a>'],
    ['#test', '<a href="/product/test">#test</a>'],
]);

it('can render task with both user and product mentions correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['#test admin @te-st', '<a href="/product/test">#test</a> admin <a href="/@te-st">@te-st</a>'],
    ['Hello #test @te-st', 'Hello <a href="/product/test">#test</a> <a href="/@te-st">@te-st</a>'],
    ['#te_st @te_st', '<a href="/product/te_st">#te_st</a> <a href="/@te_st">@te_st</a>'],
    ['#te-st @te-st', '<a href="/product/te-st">#te-st</a> <a href="/@te-st">@te-st</a>'],
    ['#test @test', '<a href="/product/test">#test</a> <a href="/@test">@test</a>'],
]);

it('can render task with links correctly', function ($task, $expected) {
    expect(Helper::renderTask($task))->toEqual($expected);
})->with([
    ['ftp://example.com/loremipsumtest', "<a class='link' href='ftp://example.com/loremipsumtest'>ftp://example.com/loremipsumte...</a>"],
    ['http://example.com/test Lorem', "<a class='link' href='http://example.com/test'>http://example.com/test</a> Lorem"],
    ['https://example.com/test', "<a class='link' href='https://example.com/test'>https://example.com/test</a>"],
    ['http://example.com/test', "<a class='link' href='http://example.com/test'>http://example.com/test</a>"],
    ['ftps://example.com/test', "<a class='link' href='ftps://example.com/test'>ftps://example.com/test</a>"],
    ['ftp://example.com/test', "<a class='link' href='ftp://example.com/test'>ftp://example.com/test</a>"],
]);

it('can render task with plain text correctly', function () {
    expect(Helper::renderTask('Jean shorts scenester fingerstache gentrify.'))
        ->toEqual('Jean shorts scenester fingerstache gentrify.');
});

it('can render due date correctly', function ($days, $expected) {
    $date = carbon()->addDays($days);
    $expect = str_replace('-format-', $date->format('Y-m-d'), $expected);

    expect(Helper::renderDueDate($date))->toEqual($expect);
})->with([
    [0, "<time datetime='-format-' class='me-2 text-danger'>Due today</time>"],
    [1, "<time datetime='-format-' class='me-2 text-info'>Due tomorrow</time>"],
    [2, "<time datetime='-format-' class='me-2 text-success'>Due in 2 days</time>"],
    [3, "<time datetime='-format-' class='me-2 text-success'>Due in 3 days</time>"],
    [-2, "<time datetime='-format-' class='me-2 text-danger'>Overdue by 1 day</time>"],
    [-3, "<time datetime='-format-' class='me-2 text-danger'>Overdue by 2 days</time>"],
    [-4, "<time datetime='-format-' class='me-2 text-danger'>Overdue by 3 days</time>"],
]);

it('can covert text to plural', function ($count, $word, $expected) {
    expect(str_plural($word, $count))->toEqual($expected);
})->with([
    [0, 'following', 'followings'],
    [1, 'following', 'following'],
    [10, 'following', 'followings'],
]);

test('git() can return a string when executed', function () {
    assertMatchesRegularExpression('/[0-9a-f]{4,9}/', git('rev-parse --short HEAD'));
});

test('carbon() can return instance of carbon', function () {
    expect(carbon())->toBeInstanceOf(Carbon::class);
});

test('carbon() can return null with no correct argument', function () {
    expect(carbon('null'))->toBeNull();
});

test('git() can return null with no correct argument', function () {
    expect(git('push'))->toBeNull();
});
