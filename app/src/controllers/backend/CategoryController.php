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

    public function editViewAction(Request $request, Response $response, $args){
        try {
            $edit = $this->em->getRepository('App\Model\Categories')->findOneBy(['slug' => $args['slug']]);

        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }

        $this->view->render($response, 'backend/category/edit_category.html',[
            'category' => $edit
        ]);
        return $response;
    }

    public function editCategoryAction(Request $request, Response $response, $args){
        if($request->isPost()){
            $data = $request->getParsedBody();

            $title = $data['category_title'];
            $slug = trim($title);
            $slug = str_replace(' ', '-', $slug);
            $isParent = false;

            if($data['cat']){
                $cate_id = $data['cat'];
            } else {
                $cate_id = 0;
                $isParent = true;
            }

            $arr = implode(',',$args['slug']);
            $category = $this->em->createQuery("UPDATE App\Model\Categories c SET c.title = ($title), c.slug = ($slug), c.isParent = ($isParent), c.parent = ($cate_id) WHERE c.slug IN ($arr)")
                ->getResult();
        }
        $this->view->render($response, 'backend/category/edit_category.html', [
            'edit_category' => $category
        ]);
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