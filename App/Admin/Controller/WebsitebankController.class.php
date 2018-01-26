<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-8
 * Time: 下午12:28
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Think\Upload;

class WebsitebankController extends AdminController {
    public function _initialize(){
        parent::_initialize();
    }
    //网站汇款银行卡帐号列表
    public function index(){
       
      	//$where['status'] = 1;
      	$where=array();
        //数据表操作
        $Website_bank = M('Website_bank');
        $count      = $Website_bank->where($where)->count();// 查询满足要求的总记录数
        $Page       = new Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $Website_bank
            ->where($where)
            ->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    /**
     * 添加银行卡
     */
    public function addBank(){
        if(IS_POST){
        	//调用模型
            $Website_bank= D('Website_bank');
          //执行并判断是否添加成功
            if($r = $Website_bank->create()){
            	
                if($Website_bank->add($r)){
                    $this->success('添加成功',U('Websitebank/index'));
                    return;
                }else{
                    $this->error('服务器繁忙,请稍后重试');
                    return;
                }
            }else{
                $this->error($Website_bank->getError());
                return;
            }
        }else{
            $this->display();
        }
    }
    
    /**
     * 修改银行卡
     */
    public function saveBank(){
        //获取选中银行卡的ID
        $bank_id = I('get.bank_id','','intval');
        //调用模型
        $Website_bank = D('Website_bank');
        if(IS_POST){
            $bank_id = I('post.bank_id','','intval');
            $where['bank_id'] = $bank_id;
            //执行操作并判断是否操作成功
            if($r = $Website_bank->create()){
            	 
            	if($Website_bank->save($r)){
            		$this->success('修改成功',U('Websitebank/index'));
            		return;
            	}else{
            		$this->error('服务器繁忙,请稍后重试');
            		return;
            	}
            }else{
            	$this->error($Website_bank->getError());
            	return;
            }
        }else{
            if($bank_id){
                $where['bank_id'] = $bank_id;
                $list = $Website_bank->where($where)->find();
                $this->assign('list',$list);
                $this->display();
            }else{
                $this->error('参数错误');
                return;
            }
        }
    }
    /**
     * 删除银行卡
     */
    public function delBank(){
    	
    	if(empty($_POST['bank_id'])){
    		$info['status'] = -1;
    		$info['info'] ='传入参数有误';
    		$this->ajaxReturn($info);
    	}
    	//获取选中的银行卡bank_id
        $bank_id = I('post.bank_id','','intval');
        //执行删除
        $r = M('Website_bank')->delete($bank_id);

        if(!$r){
          	$info['status'] = 0;
        	$info['info'] ='删除失败';
        	$this->ajaxReturn($info);
        }
        
        $info['status'] = 1;
        $info['info'] ='删除成功';
        $this->ajaxReturn($info);
    }

    
}