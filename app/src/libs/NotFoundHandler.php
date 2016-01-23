<?php

namespace App\Libs;


use Slim\Handlers\NotFound;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotFoundHandler extends NotFound {
    private $view;

    public function __construct(Twig $view) {
        $this->view = $view;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response) {
        parent::__invoke($request, $response);

        if(strpos($request->getUri()->getPath(), '/admin/') !== false) {
            $this->view->render($response, 'backend/404.html');
        } else {
            $this->view->render($response, '404.html');
        }


        return $response->withStatus(404);
    }
}