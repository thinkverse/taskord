<?php

/*
|--------------------------------------------------------------------------
| Test user roles
|--------------------------------------------------------------------------
|
| 1 => Staff
| 2 => Test User
| 3 => Suspended User
| 4 => Spammy/Flagged User
| 5 => Un-verified User
|
*/

dataset('model-data', [
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['123', 2, true],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);

dataset('like-data', [
    [2, true], // test can like
    [3, false], // suspend can't like
    [4, false], // spammy can't like
    [5, false], // un-verified can't like
]);

dataset('follow-data', [
    [1, 1, false], // Cannot follow staff -> staff
    [3, 1, false], // Cannot follow suspended -> staff
    [4, 2, false], // Cannot follow spammy -> staff
    [2, 1, true], // Can follow test -> staff
]);
