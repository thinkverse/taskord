<?php

dataset('model-content', [
    ['Hello world from test!', 2, true],
    ['😊🤗💜✨👍', 2, true],
    ['', 2, false],
    ['12', 2, false],
    ['Hello from suspended account!', 3, false],
    ['Hello from spammy account!', 4, false],
    ['Hello from un-verified account!', 5, false],
]);
