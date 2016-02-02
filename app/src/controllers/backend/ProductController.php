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
use App\Model\Categories;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ProductController extends BaseController
{
    public function indexAction(Request $request, Response $response){
        return $this->view->render($response, 'backend/products/products.html');
    }

    public function productCategoryAction(Request $request, Response $response, $args) {
        $id = $request->getParam('cat');
        $page = (isset($args['page'])) ? $args['page']: 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $dql = "SELECT c FROM App\Model\Categories c WHERE c.id=$id";
        $cat = $this->em->createQuery($dql)
            ->getResult();
        if($cat['isParent'] == false){
            $dql = "SELECT p FROM App\Model\Products p WHERE p.category=$id";
            $products = $this->em->createQuery($dql)
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getResult();
            $all = $this->em->createQuery($dql)
                ->getResult();
        } else {
            $cats = $this->em->getRepository('App\Model\Categories')->findBy(['parent'=> $cat->getId()]);
            $cid=[];
            foreach($cats as $c){
                $cid[] =  $c->getId();
            }

            $arr = implode(',',$cid);
            $products = $this->em->createQuery("SELECT p FROM App\Model\Products AS p WHERE p.category IN ($arr)")
                ->setMaxResults($limit)
                ->setFirstResult($offset)
                ->getResult();
            $all = $this->em->this->createQuery("SELECT p FROM App\Model\Products AS p WHERE p.category IN ($arr)")
                ->getResult();
        }

        $publishproducts = 0;

        foreach($all as $item){
            if($item->getPublish()) $publishproducts++;
        }
        $count = count($all);
        $totalPage = ceil($count/$limit);

        $this->view->render($response, 'backend/products/products.html', [
            'products' => $products,
            'cat' => $cat,
            'totalPage' => $totalPage,
            'currentPage' => $page,
            'total_products' => $count,
            'publish_products' => $publishproducts
        ]);

        return $response;
    }

}