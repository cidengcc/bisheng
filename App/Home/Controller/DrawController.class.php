<?php
namespace Home\Controller;
use Home\Controller\HomeController;
use Think\Page;
use Think\Upload;

class DrawController extends HomeController {

    public function _initialize(){
        parent::_initialize();
    }
    //空操作
    public function _empty(){
        header("HTTP/1.0 404 Not Found");
        $this->display('Public:404');
    }
//    显示提现主页
    public function index(){
      
        $this->display();
    }
}