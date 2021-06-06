<?php

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

dataset('like', [
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['123', 2, true],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
