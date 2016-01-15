<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class HomeController extends BaseController
{
    public function dispatch(Request $request, Response $response, $args)
    {
        $this->logger->info("Home page action dispatched");

        $this->flash->addMessage('info', 'Sample flash message');
try {
        $news = $this->em->getRepository('App\Model\Products')->findBy([], ['updatedAt' => 'DESC'], 3);

        $feature = $this->em->getRepository('App\Model\Products')->findBy(['feature' => true]);
} catch (\Exception $e) {
    echo $e->getMessage(); die;
}

        $this->view->render($response, 'index.html', ['features_products' => $feature, 'new_products' => $news]);
        return $response;
    }

}
