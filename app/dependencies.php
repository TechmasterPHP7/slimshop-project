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

    if ($categories) $categories = json_decode($categories);

    $view->getEnvironment()->addGlobal('__cates', $categories);
    $view->getEnvironment()->addGlobal('__user', $_SESSION['user']);
    return $view;
};

$container['redis'] = function ($c) {
    $redis = new Redis();
    if (!$redis->connect('127.0.0.1', 6379)) {
        $c->get('logger')->error('Redis is not running!');
        echo 'Redis is not running!';
        die;
    };

    $cate = $c->get('em')->getRepository('App\Model\Categories')->findBy([], ['id' => 'ASC']);

    foreach ($cate as $item) {
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

    $em = \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
    // check if connection is alive
    try {
        $em->getConnection()->connect();
    } catch (\Exception $e) {
        $c->get('logger')->error($e->getMessage());
        echo $e->getMessage();
        die;
    }

    return $em;
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

$container['fig'] = function($c) {
    return new Dflydev\FigCookies\Cookies;
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

$container['App\Controller\CartController'] = function ($c) {
    return new App\Controller\CartController($c);
};
$container['App\Controller\UserController'] = function ($c) {
    return new App\Controller\UserController($c);
};