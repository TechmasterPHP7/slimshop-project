<?php

namespace App\Controller\Backend;

use App\Controller\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends BaseController
{
    public function indexAction(Request $request , Response $response , $args )
    {
        return $this->view->render($response, 'backend/index.html');

    }
}