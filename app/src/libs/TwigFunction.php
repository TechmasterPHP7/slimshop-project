<?php

namespace App\Libs;


class TwigFunction
{
    /**
     * @param $imgs
     * @param $index
     * @return string
     */
    static function getImage_filter($imgs, $index)
    {
        if (!$index) $index = 0;
        if ($imgs != null && $imgs != '') {
            $result = explode(':::', $imgs)[$index];
            if (!file_exists(BASE_DIR . $result))
                $result = '/assets/images/no-image.jpg';
        } else {
            $result = BASE_DIR . '/assets/images/no-image.jpg';
        }
        return $result;
    }

    static function recursive_replace($matches)
    {
        $regex = "/(<([^>]+)>)/i";
        return preg_replace($regex, "", $matches[0]);
    }

    /**
     * @param $input
     * @param $length
     * @param $lastStr
     * @return mixed|string
     */
    static function title_length_filter($input, $length, $lastStr)
    {
        $regex = "/(<([^>]+)>)/i";
        $result = preg_replace_callback($regex, 'self::recursive_replace', $input);
        if ($length > 0) {
            $result = substr($result, 0, $length);
        }
        if ($lastStr != null && strlen($input) > $length) {
            $result = substr($result, 0, strrpos($result, ' '));
            $result .= ' ' . $lastStr;
        }
        return $result;
    }

    /**
     * @param $totalPage
     * @param $current_page
     * @param $link [example: /products/page/{page} ]
     */
    static function pager_function($totalPage, $current_page, $link)
    {
        $start = 1;
        $end = 5;
        if ($totalPage < 5) $end = $totalPage;
        if ($current_page > 3 && $totalPage > 5) {
            $start = $current_page - 2;
            if ($current_page < $totalPage - 2) {
                $end = $current_page + 2;
            } else $end = $totalPage;
        }
        $html = '';

        if ($totalPage > 1) {
            $html .= '<ul class="pagination">';

            if ($current_page > 1) {
                $html .= '<li><a href="' . str_replace('{page}', $current_page - 1, $link) . '">&laquo;</a></li>';
            }

            for ($i = $start; $i <= $end; $i++) {
                if ($current_page == $i)
                    $html .= '<li class="active"><a href="#">' . $i . '</a></li>';
                else
                    $html .= '<li><a href="' . str_replace('{page}', $i, $link) . '">' . $i . '</a></li>';
            }

            if ($current_page != $totalPage) {
                $html .= '<li><a href="' . str_replace('{page}', $current_page + 1, $link) . '">&raquo;</a></li>';
            }

            $html .= '</ul>';
        }
        echo $html;
    }

    static function preg_match_func($pattern, $input) {
        return preg_match($pattern, $input);
    }
}