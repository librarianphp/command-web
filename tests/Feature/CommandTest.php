<?php

it('loads index page', function () {
    $app = getLibrarian('/');
    $app->runCommand(['minicli', 'web', 'index']);
})->expectOutputRegex('/template listing/');

it('loads custom index page', function () {
    $app = getLibrarian('/', [], ['site_index' => 'posts/test0']);
    $app->runCommand(['minicli', 'web', 'index']);
})->expectOutputRegex('/Devo Produzir Conteúdo em Português ou Inglês?/');

it('loads custom index template', function () {
    $app = getLibrarian('/', [], ['site_index' => 'posts/test0', 'site_index_tpl' => 'content/custom_index.html.twig']);
    $app->runCommand(['minicli', 'web', 'index']);
})->expectOutputRegex('/custom index/');

it('loads single post', function () {
    $app = getLibrarian('/posts/test1');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex('/Testing Markdown Front Matter/');

it('loads nested content', function () {
    $app = getLibrarian('/docs/en/test0');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex('/Testing Sub-Level En/');

it('loads article list from base content type', function () {
    $app = getLibrarian('/posts');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex('/template listing Blog posts/');

it('loads article list from nested content type', function () {
    $app = getLibrarian('/docs/en');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex('/template listing English Docs/');

it('loads article list from parent content type', function () {
    $app = getLibrarian('/docs/');
    $app->runCommand(['minicli', 'web', 'content']);
})->expectOutputRegex('/template listing Docs/');
