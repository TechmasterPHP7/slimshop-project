<?php
/**
 * Created by PhpStorm.
 * User: hak2c
 * Date: 1/11/16
 * Time: 17:45
 */

namespace App\Controller;

use App\Model\Products;
use Slim\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CartController extends BaseController
{
    public function addCartAction(Request $request, Response $response) {
        $id = $request->getParsedBody('id');

        if(isset($id)) {
            setcookie('id', $id, time() + 86400);
            $result = [
                'success' => true
            ];
            $response = $response->withHeader('Content-type', 'application/json');
            $response->withSatus(200);
        } else {
            $result = [
                'success' => false,
                'error' => 'Lỗi setcookie'
            ];
            $response = $response->withHeader('Content-type', 'application/json');
            $response->withSatus(500);
        };

        return $response->write(json_encode($result));
    }

//    public function removeCartAction(Request $request, Response $response, $id) {
//        if(isset($_COOKIE[$id]) && $_COOKIE[$id] != '') {
//
//        };
//
//        return $response;
//    }

    public function viewCartAction(Request $request, Response $response) {

        if(isset($_COOKIE['id']) && $_COOKIE['id'] != '') {
            $id = $_COOKIE['id'];
            $products = $this->em->getRepository('App\Model\Products')->findBy(['id' => $id]);

            $this->view->render($response, '/cart/cart.html', [
                'cart' => $products
            ]);
        };

        return $response;
    }

}