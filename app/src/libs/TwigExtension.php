<?php

namespace App\Libs;

use \Twig_SimpleFilter;
use \Twig_SimpleFunction;
use App\Libs\TwigFunction;


class TwigExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'phpTwigExtension';
    }

    /**
     * Returns a list of filters.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array(
            new Twig_SimpleFilter('getImage', 'App\Libs\TwigFunction::getImage_filter'),
            new Twig_SimpleFilter('title_length', 'App\Libs\TwigFunction::title_length_filter')
        );
        return $filters;
    }

    /**
     * Return a list of functions
     *
     * @return array
     */
    public function getFunctions() {
        $functions = array(
            new Twig_SimpleFunction('preg_match', 'App\Libs\TwigFunction::preg_match_func'),
            new Twig_SimpleFunction('pager', 'App\Libs\TwigFunction::pager_function'),
        );
        return $functions;
    }
}


