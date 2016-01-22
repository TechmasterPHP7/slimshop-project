<?php
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

$app->get('/cart', 'App\Controller\CartController:addCartAction');

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


// <- Cart ->
$app->post('/addcart','App\Controller\CartController:addCartAction');

$app->post('/removecart', 'App\Controller\CartController:removeCartAction');

$app->get('/cart', 'App\Controller\CartController:vỉewCartAction');

// <- Cart ->