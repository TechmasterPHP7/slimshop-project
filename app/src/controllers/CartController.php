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
        $id = $request->getParam('id');

        if(isset($id)) {
            if(!isset($_COOKIE['ids'])){
                setcookie('ids', $id, time() + 86400);
            } else {
                setcookie('ids', $_COOKIE['ids'] . ',' . $id, time() + 86400);
            }
            $result = [
                'success' => true
            ];
            $response = $response->withHeader('Content-type', 'application/json');
            $response->withStatus(200);
        } else {
            $result = [
                'success' => false,
                'error' => 'Lỗi setcookie'
            ];
            $response = $response->withHeader('Content-type', 'application/json');
            $response->withStatus(500);
        };
        return $response->write(json_encode($result));
    }

//    public function removeCartAction(Request $request, Response $response, $id) {
//        $id = $request->getParam('id');
//
//        if(isset($id)) {
//            setcookie('ids', $id, time() - 3600);
//            $result = [
//                'success' => true
//            ];
//            $response = $response->withHeader('Content-type', 'application/json');
//            $response->withStatus(200);
//        } else {
//            $result = [
//                'success' => false,
//                'error' => 'Lỗi setcookie'
//            ];
//            $response = $response->withHeader('Content-type', 'application/json');
//            $response->withStatus(500);
//        };
//        $this->viewCartAction();
//        return $response->write(json_encode($result));
//    }

    public function viewCartAction(Request $request, Response $response) {
        if(isset($_COOKIE['ids'])){
            $args = explode(',', $_COOKIE['ids']);
            $dql = "SELECT p FROM App\Model\Products p WHERE p.id IN (" . $_COOKIE['ids'] . ")";
            $products = $this->em->createQuery($dql)->getResult();

        };
        $this->view->render($response, 'cart/cart.html', [
            'cart' => $products
        ]);
        return $response;
    }

    public function totalPriceAction(Request $request, Response $response){
        
    }
}