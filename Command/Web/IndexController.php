<?php

namespace librarianphp\Web;

use Librarian\Provider\ContentServiceProvider;
use Librarian\Provider\TwigServiceProvider;
use Librarian\Response;
use Librarian\WebController;

class IndexController extends WebController
{
    public function handle(): void
    {
        /** @var TwigServiceProvider $twig */
        $twig = $this->getApp()->twig;
        /** @var ContentServiceProvider $content_provider */
        $content_provider = $this->getApp()->content;
        $request = $this->getRequest();

        if ($this->getApp()->config->site_index !== null) {
            $indexTpl = $this->getApp()->config->site_index_tpl ?? 'content/single.html.twig';
            $content = $content_provider->fetch($this->getApp()->config->site_index);
            if ($content) {
                $response = new Response($twig->render($indexTpl, [
                    'content' => $content,
                ]));

                $response->output();

                return;
            }
        }

        $page = 1;
        $limit = $this->getApp()->config->posts_per_page ?? 10;
        $params = $request->getParams();

        if (array_key_exists('page', $params)) {
            $page = $params['page'];
        }

        $start = ($page * $limit) - $limit;

        $content_list = $content_provider->fetchAll($start, $limit);

        $output = $twig->render('content/listing.html.twig', [
            'content_list' => $content_list,
            'total_pages' => $content_provider->fetchTotalPages($limit),
            'current_page' => $page,
        ]);

        $response = new Response($output);

        $response->output();
    }
}
