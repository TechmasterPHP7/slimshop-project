<?php
/**
 * Created by PhpStorm.
 * User: hak2c
 * Date: 1/5/16
 * Time: 17:50
 */

namespace App\Controller;

use Slim\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ProductController extends BaseController
{
    public function productAction(Request $request ,Response $response,$args){
        $messages = $this->flash->getMessage('info');

        $page = (isset($args['page'])) ? $args['page']: 1;
//        var_dump($page);die;
        $limit = 12;
        $offset = ($page - 1) * $limit;

        try {
            //$products = $this->em->getRepository('App\Model\Products')->findAll();
            $products = $this->em->getRepository('App\Model\Products')->findBy([],['id' => 'ASC'],$limit,$offset);
            //select * from products  order by id ASC , limit = 100  offset = 1
            $all = $this->em->getRepository('App\Model\Products')->findBy([]);
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }


        $count = count($all);
        $totalPage = ceil($count/$limit);
        //var_dump($count, $totalPage); die;

        $this->view->render($response, 'product/products.html', [
            'products' => $products,
            'cat' => '',
            'totalPage' => $totalPage,
            'currentPage' => $page
        ]);
        return $response;
    }


    public function productDetailAction(Request $request, Response $response, $args)
    {

        try {

            $product_detail = $this->em->getRepository('App\Model\Products')->findOneBy(['slug' => $args['slug']]);

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }


        $this->view->render($response, 'product/product_detail.html',[
            'p'=>$product_detail
        ]);
        return $response;
    }

    public function productCategoryAction(Request $request, Response $response, $args)
    {
        try {


            $page = (isset($args['page'])) ? $args['page']: 1;
            $limit = 6;
            $offset = ($page - 1) * $limit;


            $cat = $this->em->getRepository('App\Model\Categories')->findOneBy(['slug'=>$args['slug']]);
            if($cat->getIsParent() == false){
                //select * from products where                                    cagtegory=... order by id desc limit 23 offset 0;
                $category = $this->em->getRepository('App\Model\Products')->findBy(['category'=> $cat->getId()],['id'=>'ASC'],$limit,$offset);
                $all = $this->em->getRepository('App\Model\Categories')->findBy([]);
            }else{

                $cats = $this->em->getRepository('App\Model\Categories')->findBy(['parent'=> $cat->getId()]);
                $cid=[];
                foreach($cats as $c){
                    $cid[] =  $c->getId();
//                    array_push($cid, $c->getId());
                }

                $arr = implode(',',$cid);
                //select * from products where category in (3,4,5,6,7,8,9,10,11,12,13,14)
                $category = $this->em->createQuery("SELECT p FROM App\Model\Products AS p WHERE p.category IN ($arr)")
                    ->setMaxResults($limit)
                    ->setFirstResult($offset)
                    ->getResult();
                $all = $this->em->getRepository('App\Model\Products')->findBy([]);

            }

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }
        $count = count($all);
        $totalPage = ceil($count/$limit);

        $this->view->render($response, 'product/products.html',[
            'products' => $category,
            //'cat'=> $cat->getTitle()
            'cat'=>$cat,
            'totalPage' => $totalPage,
            'currentPage' => $page

        ]);
        return $response;
    }

}