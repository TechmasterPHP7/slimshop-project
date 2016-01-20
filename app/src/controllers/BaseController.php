<?php

namespace App\Controller;

use Slim\Container;
class BaseController
{
    protected $view;
    protected $logger;
    protected $flash;
    protected $em;  // Entities Manager
    protected $redis;
    protected $fig;

    public function __construct(Container $c)
    {
        $this->view = $c->get('view');
        $this->logger = $c->get('logger');
        $this->flash = $c->get('flash');
        $this->em = $c->get('em');
        $this->redis = $c->get('redis');
        $this->fig = $c->get('fig');
    }
}