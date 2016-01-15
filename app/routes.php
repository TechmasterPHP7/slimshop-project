<?php
// Routes

$app->get('/', 'App\Controller\HomeController:dispatch')
    ->setName('homepage');

$app->get('/cart', 'App\Controller\CartController:viewCart')
    ->setName('cart_page');

$app->get('/login', 'App\Controller\UserController:viewLoginPage')
    ->setName('login_page');

$app->post('/login', 'App\Controller\UserController:loginPage')
    ->setName('login_page');

$app->get('/products','App\Controller\ProductController:productAction');

$app->get('/products/page/{page}','App\Controller\ProductController:productAction');

$app->get('/products/{slug}', 'App\Controller\ProductController:productDetailAction');

$app->get('/products/category/{slug}','App\Controller\ProductController:productCategoryAction');

$app->get('/products/category/{slug}/page/{page}','App\Controller\ProductController:productCategoryAction');





