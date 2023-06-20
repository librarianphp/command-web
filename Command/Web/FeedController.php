<?php

namespace librarianphp\Web;

use Librarian\Content;
use Librarian\Provider\FeedServiceProvider;
use Librarian\WebController;
use Librarian\Provider\ContentServiceProvider;
use Suin\RSSWriter\Channel;
use Suin\RSSWriter\Feed;
use Suin\RSSWriter\Item;

class FeedController extends WebController
{
    public function handle(): void
    {
        /** @var FeedServiceProvider $feed_provider */
        $feed_provider = $this->getApp()->feed;

        $feed = $feed_provider->buildFeed();

        header('Content-type: application/rss+xml');
        echo $feed;
    }
}
