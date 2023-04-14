<?php

test('Index page is correctly loaded', function () {
    $app = getLibrarianIndex();
    $app->runCommand(['minicli', 'web', 'index']);
})->expectOutputRegex("/template listing/");


test('Content page posts/test0 is correctly loaded', function () {
    $app = getLibrarianContent('test0');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex("/template single/");

test('Content page posts/test1 is correctly loaded', function () {
    $app = getLibrarianContent('test1');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex("/template single/");

test('Content page posts/test2 is correctly loaded', function () {
    $app = getLibrarianContent('test2');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex("/template single/");