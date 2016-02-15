<?php
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

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

// Cart router
$app->post('/addcart','App\Controller\CartController:addCartAction');

$app->get('/removecart', 'App\Controller\CartController:removeCartAction');

$app->get('/cart', 'App\Controller\CartController:viewCartAction');

$app->get('/checkout', 'App\Controller\CartController:viewCheckOutAction');

// Search Router

$app->get('/search', 'App\Controller\CartController:searchNameItemAction');

// backend router

$app->group('/admin', function () use ($app) {
    $app->get('',  'App\Controller\Backend\DashboardController:indexAction');
    $app->get('/login',  'App\Controller\Backend\UserController:loginAction');
    $app->get('/admin/products', 'App\Controller\Backend\ProductController:indexAction');
    $app->get('/admin/products/new', 'App\Controller\Backend\ProductController:newProductAction');
})->add(function ($request, $response, $next) {
    if($_SESSION['user']['role'] == 1) {
        $response = $next($request, $response);
        return $response;
    } else {
        $this->flash->addMessage('error', 'Permission denied');
        return $response->withStatus(301)->withHeader('Location', '/login');
    }
});

// Product in backend

$app->get('/admin/products', 'App\Controller\Backend\ProductController:indexAction');

$app->get('/admin/products/new', 'App\Controller\Backend\ProductController:newProductAction');

$app->post('/admin/products/add', 'App\Controller\Backend\ProductController:addProductAction');

$app->get('/admin/products/f', 'App\Controller\Backend\ProductController:productCategoryAction');

// Categories in backend

$app->get('/admin/category', 'App\Controller\Backend\CategoryController:indexAction');

$app->post('/admin/category/delete', 'App\Controller\Backend\CategoryController:deleteCategoryAction');

$app->get('/admin/category/new', 'App\Controller\Backend\CategoryController:newCategoryAction');

$app->post('/admin/category/add', 'App\Controller\Backend\CategoryController:addCategoryAction');

$app->get('/admin/category/{slug}/page/{page}','App\Controller\Backend\ProductController:productCategoryAction');
