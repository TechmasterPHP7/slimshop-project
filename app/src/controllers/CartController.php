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
    public function addCartAction(Request $request, Response $response){


        if(isset($_COOKIE['addToCart'] && $_COOKIE['addToCart'] != '')) {
            $id = $_COOKIE['addToCart'];
            $product = $this->em->getRepository('App\Model\Products')->findBy(['id' => $id]);

            $this->view->render($response, 'cart.html', [
                'cart' => $product
            ]);
        };
    }

}