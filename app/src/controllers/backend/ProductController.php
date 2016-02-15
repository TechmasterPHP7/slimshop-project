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

    public function newProductAction(Request $request, Response $response){
        return $this->view->render($response, 'backend/products/new_products.html');
    }

    public function addProductAction(Request $request, Response $response){
        if($request->isPost()){
            $data = $request->getParsedBody();
            $title = $data['product_title'];

            $slug = trim($title);
            $slug = str_replace(' ','-',$slug);

            $code = $data['product_code'];
            $color = $data['product_color'];
            $material = $data['product_material'];
            $source = $data['product_source'];
            $size = $data['product_size'];
            $price = $data['product_price'];
            $detail = $data['product_detail'];
            $cate_id = $data['cat'];
            $quantity = $data['product_quantity'];

            $product = new Products();
            $product->setTitle($title);
            $product->setSlug($slug);
            $product->setCode($code);
            $product->setColor($color);
            $product->setMaterial($material);
            $product->setSource($source);
            $product->setSize($size);
            $product->setPrice($price);
            $product->setDetail($detail);
            $product->setFeature(false);
            $product->setPublish(true);
            $product->setQuantity($quantity);
//            $product->setCategory($cate_id);

            $this->em->persist($product);
            $this->em->flush();
        }

        return $this->view->render($response, 'backend/products/new_products.html',[
            'new_product' => $product
        ]);
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