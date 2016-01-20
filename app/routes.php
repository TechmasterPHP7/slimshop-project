<?php
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

$app->get('/cart', 'App\Controller\CartController:viewCart')
    ->setName('cart_page');

$app->get('/login','App\Controller\UserController:loginAction')
    ->setName('login');

$app->post('/login','App\Controller\UserController:loginAction');

$app->post('/register','App\Controller\UserController:registerAction');

$app->get('/logout','App\Controller\UserController:logoutAction');


$app->get('/products','App\Controller\ProductController:productAction');

$app->get('/products/page/{page}','App\Controller\ProductController:productAction');

$app->get('/products/{slug}', 'App\Controller\ProductController:productDetailAction');

$app->get('/products/category/{slug}','App\Controller\ProductController:productCategoryAction');

$app->get('/products/category/{slug}/page/{page}','App\Controller\ProductController:productCategoryAction');

// backend router

$app->group('/admin', function () use ($app) {
    $app->get('',  'App\Controller\Backend\DashboardController:indexAction');

    $app->get('/login',  'App\Controller\Backend\UserController:loginAction');

    $app->get('/products',  'App\Controller\Backend\ProductController:indexAction');
})->add(function ($request, $response, $next) {
    if($_SESSION['user']['role'] == 1) {
        $response = $next($request, $response);
        return $response;
    } else {
        $this->flash->addMessage('error', 'Permission denied');
        return $response->withStatus(301)->withHeader('Location', '/login');
    }
});