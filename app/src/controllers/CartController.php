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
    public function addCartAction(Request $request, Response $response, $id) {
        if(isset($_POST[$id]) ? $_POST[$id] : false) {
            $i = $_POST[$id];
            setcookie('id', $i, time() + 86400);
        }
    }

    public function removeCartAction(Request $request, Response $response) {
        if(isset($_POST['id']) ? $_POST['id'] : false) {
            $id = $_POST['id'];
            setcookie('id', $id, time() - 86400);
        }
    }

    public function viewCartAction(Request $request, Response $response){

        if(isset($_COOKIE['id'] && $_COOKIE['id'] != '')) {
            $id = $_COOKIE['id'];
            $products = $this->em->getRepository('App\Model\Products')->findBy([], ['id' => $id]);

            $this->view->render($response, 'cart.html', [
                'cart' => $products
            ]);
        };
    }

}