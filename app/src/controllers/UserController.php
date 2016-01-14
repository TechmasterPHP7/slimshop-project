<?php
/**
 * Created by PhpStorm.
 * User: hak2c
 * Date: 1/13/16
 * Time: 16:52
 */

namespace App\Controller;

use Slim\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends BaseController
{
    public function viewLoginPage(Request $request, Response $response) {
        $this->view->render($response, 'login.html');
        return $response;
    }

    public function loginPage(Request $request, Response $response) {
        $this->view->render($response, 'login.html');
        return $response;
    }
}