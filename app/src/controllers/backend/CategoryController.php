<?php
/**
 * Created by PhpStorm.
 * User: phamthanhha
 * Date: 2/1/16
 * Time: 4:52 PM
 */

namespace App\Controller\Backend;

use App\Controller\BaseController;
use App\Model\Categories;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CategoryController extends BaseController
{
    public function indexAction(Request $request, Response $response){
        return $this->view->render($response, 'backend/category/category.html');
    }

    public function deleteCategoryAction(Request $request, Response $response){
        if($request->isPost()){
            $data = $request->getParsedBody();

            if($data['action'] == 'trash'){
                $args = implode(',',$data['check_category']);
//                var_dump($args);die;
                $dql = $this->em->createQuery("DELETE App\Model\Categories c WHERE c.id IN ($args)")
                    ->getResult();
                $this->view->render($response, 'backend/category/category.html');
            }
        };
        return $response;
    }

    public function addCategoryAction(Request $request, Response $response){
        if($request->isPost()){
            $data = $request->getParsedBody();

            if($data['cat']){
                $cate_id = $data['cat'];
                $title = $data['category_name'];

                $slug = trim($title);
                $slug = str_replace(' ', '-', $slug);

                $category = new Categories();
                $category->setTitle($title);
                $category->setSlug($slug);
                $category->setParent($cate_id);

                $this->em->persist($category);
                $this->em->flush();
            } else {
                $title = $data['category_name'];

                $slug = trim($title);
                $slug = str_replace(' ', '-', $slug);

                $category = new Categories();
                $category->setTitle($title);
                $category->setSlug($slug);
                $category->setIsParent(true);

                $this->em->persist($category);
                $this->em->flush();
            }
        }
        $this->view->render($response, 'backend/category/category.html');
        return $response;
    }
}