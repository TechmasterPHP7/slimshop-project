<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController extends BaseController
{
    public function dispatch(Request $request, Response $response, $args)
    {
        // slider
        $news = $this->em->getRepository('App\Model\Products')->findBy([], ['updatedAt' => 'DESC'], 3);

        // Feature Items
        $feature = $this->em->getRepository('App\Model\Products')->findBy(['feature' => true], ['id' => 'ASC'], 9);

        // New item
        $new_item = $this->em->getRepository('App\Model\Products')->findBy([], ['createdAt' => 'DESC'], 9);

            $this->view->render($response, 'index.html', [
            'features_products' => $feature,
            'new_products' => $news,
            'new_items' => $new_item
        ]);
        return $response;
    }

}
