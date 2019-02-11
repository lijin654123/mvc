<?php
namespace controller;

use \framework\Tpl;

/**
 *
 */
class Controller extends Tpl
{

    public function __construct()
    {
        $config = $GLOBALS['config'];
        parent::__construct($config['TPL_VIEW'], $config['TPL_CACHE']);
    }
    public function display($viewName, $isInclude = true, $uri = null)
    {
        //未指定模板文件，用默认
        if (empty($viewName)) {
            $viewName = $_GET['m'] . '/' . $_GET['a'] . '.html';
        }
        parent::display($viewName, $isInclude, $uri);
    }
}
