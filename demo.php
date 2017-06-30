<?php
namespace Wap\Controller;

use Common\Controller\HomebaseController;

class MsgController extends HomebaseController {
    
    //武汉天地店
	public function index()
	{
	    if (IS_POST) {
	        $data = I('post.');
	        if (empty(trim($data['name'])) || empty(trim($data['address'])) || empty(trim($data['phone'])) || empty(trim($data['yname'])) || 
	            empty(trim($data['content'])) || empty(trim($data['make']))) {
	                $this->ajaxReturn(1);
	            }
	        $dataInfo = array(
	            'name' => trim($data['name']),
	            'address' => trim($data['address']),
	            'phone' => trim($data['phone']),
	            'yname' => trim($data['yname']),
	            'content' => trim($data['content']),
	            'make' => trim($data['make']),
	            'addtime' => time()
	        );
	        if ($this->addOne('msg', $dataInfo) !== false) {
	            $this->ajaxReturn(2);
	        } else {
	            $this->ajaxReturn(0);
	        }
	    } else {
	        $this->display();
	    }
    }
    
    /**
     * 筛选姓名
     */
    public function msgseach()
    {
        if (IS_POST) {
            $keyword = I('post.keyword', '', 'string');
            if (empty($keyword)){
                echo '';
            }
            
            $msg = $this->getData('msg', array('name' => array('like', "%$keyword%"), 'state' => 1), 'id,name', 'addtime desc');
            
            foreach ($this->array_unset($msg, 'name') as $v){
                $html.='<dd onclick="rid('.$v['id'].')"><span>'.$v['name'].'</span></dd>';
            }
            echo $html;
        }
    }
    /**
     * 筛选地址
     */
    public function addseach()
    {
        if (IS_POST) {
            $keyword = I('post.keyword', '', 'string');
            if (empty($keyword)){
                echo '';
            }
    
            $msg = $this->getData('msg', array('address' => array('like', "%$keyword%"), 'state' => 1), 'id,address', 'addtime desc');
    
            foreach ($this->array_unset($msg, 'address') as $v){
                $html.='<dd onclick="riadd('.$v['id'].')"><span>'.$v['address'].'</span></dd>';
            }
            echo $html;
        }
    }
    /**
     * 筛选手机
     */
    public function phoneseach()
    {
        if (IS_POST) {
            $keyword = I('post.keyword', '', 'string');
            if (empty($keyword)){
                echo '';
            }
    
            $msg = $this->getData('msg', array('phone' => array('like', "%$keyword%"), 'state' => 1), 'id,phone', 'addtime desc');
    
            foreach ($this->array_unset($msg, 'phone') as $v){
                $html.='<dd onclick="ritel('.$v['id'].')"><span>'.$v['phone'].'</span></dd>';
            }
            echo $html;
        }
    }
    
    /**
     * 获取特定信息
     */
    public function msgrid()
    {
        if (IS_POST) {
            $id = I('post.id', '', 'int');
            if (empty($id) || $id == 0){
                echo '';
            }
            $msg = $this->getOne('msg', array('id' => $id, 'state' => 1), 'name,address,phone');
            echo json_encode($msg);
        }
    }
    
    /**
     * 二维数组去除特定键的重复项
     */
    public function array_unset($arr,$key)
    {   
        //$arr->传入数组   $key->判断的key值
        //建立一个目标数组
        $res = array();      
        foreach ($arr as $value) {         
            //查看有没有重复项
            if(isset($res[$value[$key]])) {
                 //有：销毁
                 unset($value[$key]);
           } else {
                $res[$value[$key]] = $value;
           }
        }
        return $res;
    }
    

}
