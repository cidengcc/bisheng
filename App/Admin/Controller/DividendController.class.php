<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
class DividendController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	//空操作
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->display('Public:404');
	}
//	显示分红股信息管理界面
	public function index(){
//		分红发行信息
		$config=M('Dividend_config')->select();
		foreach ($config as $k=>$v){
               $list[$v['name']]=$v['value'];
		}
//		查询可选择的分红钱币
		$currency = M('Currency')->field('currency_id,currency_name')->select();
		$this->assign('config',$list);
		$this->assign('currency',$currency);
       	$this->display();
     }
     
//   修改选中分红钱币资料
     public function updateCofig(){
     	foreach ($_POST as $k=>$v){
     		$rs[]=M('Dividend_config')->where("name='{$k}'")->setField('value',$v);
     	}
     	if($rs){
     		$this->success('配置修改成功');
     	}else{
     		$this->error('配置修改失败');
     	}
     }
}