<?php
/**
 *
 */
class Start
{
    public static $auto;
    public static function init()
    {
        self::$auto = new Psr4AutoLoad();
    }
    public static function router()
    {
        $m = empty($_GET['m']) ? 'index' : $_GET['m'];
        $a = empty($_GET['a']) ? 'index' : $_GET['a'];
        $_GET['m'] = $m;
        $_GET['a'] = $a;
        $m = ucfirst($m);
        $controller = 'controller\\' . $m . 'controller';
        $obj = new $controller;
        call_user_func([$obj, $a]);
    }
}
