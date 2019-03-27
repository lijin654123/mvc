<?php
namespace controller;
use framework\Db;
/**
 *
 */
class IndexController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $Db=new Db();
        $head = 'head';
        $title = 'tpl';
        $data = ['wonderful', 'world'];
        $this->assign('head', $head);
        $this->assign('title', $title);
        $this->assign('data', $data);
        $this->display('index/index.html');
    }
}
