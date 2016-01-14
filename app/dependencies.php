<?php
// DIC configuration


$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    $view->addExtension(new \App\Libs\TwigExtension());


    $categories = $c->get('redis')->get('category');

    if($categories) $categories = json_decode($categories);

    $view->getEnvironment()->addGlobal('__cates', $categories);
    return $view;
};

$container['redis'] = function ($c) {
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    $cate = $c->get('em')->getRepository('App\Model\Categories')->findBy([], ['id' => 'ASC']);

    foreach($cate as $item) {
        $categories[] = [
            'id' => $item->getId(),
            'title' => $item->getTitle(),
            'slug' => $item->getSlug(),
            'is_Parent' => $item->getIsParent(),
            'parent' => $item->getParent()
        ];
    }
    $redis->delete('category');
    $redis->set('category', json_encode($categories));

    return $redis;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// doctrine EntityManager
$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

$container['notFoundHandler'] = function ($c) {
    return new App\Libs\NotFoundHandler($c->get('view'), function ($request, $response) use ($c) {
        return $c['response']
            ->withStatus(404);
    });
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\Controller\HomeController'] = function ($c) {
    return new App\Controller\HomeController($c);
};

$container['App\Controller\ProductController'] = function ($c) {
    return new App\Controller\ProductController($c);
};

$container['App\Controller\ViewController'] = function ($c) {
    return new App\Controller\ViewController($c);
};