<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\RouterServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Librarian\Provider\LibrarianServiceProvider;

use Librarian\Request;
use Minicli\App;

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function getLibrarianIndex(string $custom = null): App
{
    $config = [
        'app_path' => [
            __DIR__ . '/../Command'
        ],
        'data_path' => __DIR__ . '/Resources/data',
        'cache_path' => __DIR__ . '/Resources/cache',
        'templates_path' => __DIR__ . '/Resources/templates',
        'debug' => true
    ];

    if ($custom) {
        $config['site_index'] = $custom;
        $config['site_index_tpl'] = "content/custom_index.html.twig";
    }

    $app = new App($config);
    $router = Mockery::mock(RouterServiceProvider::class);
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('getParams');

    $router->shouldReceive('load');
    $router->shouldReceive('getRequest')->andReturn($request);


    $app->addService('router', $router);
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $app->addService('content', new ContentServiceProvider());

    $app->librarian->boot();

    return $app;
}

function getLibrarianContent(string $slug): App
{
    $app = new App([
        'app_path' => [
            __DIR__ . '/../Command'
        ],
        'data_path' => __DIR__ . '/Resources/data',
        'cache_path' => __DIR__ . '/Resources/cache',
        'templates_path' => __DIR__ . '/Resources/templates',
        'debug' => true
    ]);

    $router = Mockery::mock(RouterServiceProvider::class);
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('getParams');
    $request->shouldReceive('getRoute')->andReturn('posts');
    $request->shouldReceive('getSlug')->andReturn($slug);

    $router->shouldReceive('load');
    $router->shouldReceive('getRequest')->andReturn($request);

    $app->addService('router', $router);
    $app->addService('twig', new TwigServiceProvider());
    $app->addService('librarian', new LibrarianServiceProvider());
    $app->addService('content', new ContentServiceProvider());

    $app->librarian->boot();

    return $app;
}