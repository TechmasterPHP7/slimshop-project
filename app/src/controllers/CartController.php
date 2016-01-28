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
//        if(isset($_COOKIE[$id]) && $_COOKIE[$id] != '') {
//
//        };
//
//        return $response;
//    }

    public function viewCartAction(Request $request, Response $response) {
        if(isset($_COOKIE['ids'])){
            $query = $this->em->createQueryBuilder()
                ->select('p')
                ->from('App\Model\Products', 'p')
                ->where('p.id',$_COOKIE['ids']);
            $q = $this->em->getQuery($query);
            $products = $this->em->execute($q);
            echo '<pre>' . PHP_EOL;
            var_dump($products);die;
            echo '</pre>';
            $this->view->render($response, 'cart/cart.html', [
                'cart' => $products
            ]);
        };
        return $response;
    }
}