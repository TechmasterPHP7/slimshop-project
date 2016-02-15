<?php
/**
 * Created by PhpStorm.
 * User: phamthanhha
 * Date: 2/1/16
 * Time: 4:52 PM
 */

namespace App\Controller\Backend;

use App\Controller\BaseController;
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
}