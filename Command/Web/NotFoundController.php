<?php

namespace librarianphp\Web;

use Librarian\Response;
use Librarian\WebController;
use Twig\Environment;

class NotFoundController extends WebController
{
    public function handle(): void
    {
        /** @var Environment $twig */
        $twig = $this->getApp()->twig;
        $output = $twig->render('error/404.html.twig', []);

        $response = new Response($output);

        $response->output();
    }
}
