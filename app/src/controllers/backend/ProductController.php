<?php
/**
 * Created by PhpStorm.
 * User: phamthanhha
 * Date: 2/1/16
 * Time: 5:02 PM
 */

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Model\Products;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController extends BaseController
{
    public function indexAction(Request $request, Response $response){

        // Total products
        $products = $this->em->getRepository('App\Model\Products')->findBy([], ['id' => 'ASC']);
        $publishs = $this->em->getRepository('App\Model\Products')->findBy(['publish' => true]);

        $totalproducts = count($products);
        $totalpublishs = count($publishs);

        return $this->view->render($response, 'backend/products/products.html',[
            'total_products' => $totalproducts,
            'total_publish' => $totalpublishs
        ]);
    }
}