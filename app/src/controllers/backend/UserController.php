<?php

namespace App\Controller\Backend;

use App\Controller\BaseController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function loginAction(Request $request , Response $response , $args )
    {
        return $this->view->render($response, 'backend/user/login.html');

    }
}