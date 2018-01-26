<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;
class ConfigController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	//空操作
	public function _empty(){
		header("HTTP/1.0 404 Not Found");
		$this->display('Public:404');
	}
	//查询表confing并显示页面
	public function index(){
		$list=M('Config')->select();
		foreach ($list as $k=>$v){
               $list[$v['key']]=$v['value'];
				
		}
		$this->assign('config',$list);
       	$this->display();
     }
//     显示客服联系方式界面
     public function customerService(){
     	$this->display();
     }
//     显示购买短信页面
     public function shortMessage(){
     	$this->display();
     }

    //显示财务设置页面
     public function finance(){
     	$this->display();
     }
    //显示修改友情\风险\提现提示及邀请规则等页面
     public function information(){
     	$this->display();
     }
     
//     显示银行列表页
     public function websiteBank(){
     	$this->display();
     }
     //文件上传(图片和表格)
     public function updateCofig(){
         //网站logo上传
         if($_FILES["logo"]["tmp_name"]){
                $_POST['logo']=$this->upload($_FILES["logo"]);
                if (!$_POST['logo']){
                    $this->error('非法上传');
                }
         }
         //微信二维码上传
         if($_FILES["weixin"]["tmp_name"]){
              $_POST['weixin']=$this->upload($_FILES["weixin"]);
              if (!$_POST['weixin']){
                  $this->error('非法上传');
              }
         }
        //新币申请表上传
         if($_FILES["biaoge_url"]["tmp_name"]){
         	$_POST['biaoge_url']=$this->upload_art($_FILES["biaoge_url"]);
         	if (!$_POST['biaoge_url']){
         		$this->error('非法上传');
         	}
         }
         //获取并判断前台修改的信息
         if (!empty($_POST['friendship_tips'])){
     	      $_POST['friendship_tips'] = I('post.friendship_tips','','html_entity_decode');
         }
         if (!empty($_POST['withdraw_warning'])){
        	$_POST['withdraw_warning'] = I('post.withdraw_warning','','html_entity_decode');
         }
         if (!empty($_POST['risk_warning'])){
             $_POST['risk_warning'] = I('post.risk_warning','','html_entity_decode');
         }
         if (!empty($_POST['VAP_rule'])){
             $_POST['VAP_rule'] = I('post.VAP_rule','','html_entity_decode');
         }
         if (!empty($_POST['disclaimer'])){
         	$_POST['disclaimer'] = I('post.disclaimer','','html_entity_decode');
         }
         if (!empty($_POST['FWTK'])){
         	$_POST['FWTK'] = I('post.FWTK','','html_entity_decode');
         }
         if (!empty($_POST['new_coin_up'])){
         	$_POST['new_coin_up'] = I('post.new_coin_up','','html_entity_decode');
         }
		 if (!empty($_POST['reg_risk_warning'])){
         	$_POST['reg_risk_warning'] = I('post.reg_risk_warning','','html_entity_decode');
         }
         //循环往数据库修改数据
     	foreach ($_POST as $k=>$v){
     		$rs[]=M('Config')->where(C("DB_PREFIX")."config.key='{$k}'")->setField('value',$v);
     	}
     	if($rs){
     		$this->success('配置修改成功');
     	}else{
     		$this->error('配置修改失败');
     	}
     }
}