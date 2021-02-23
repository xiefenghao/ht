<?php
namespace  app\index\controller;
use think\Controller;

//判断引用
 use app\index\model\Yh as YhModel;
 use app\index\validate\Yh as YhValidate;


class Yh extends Controller
{
	 protected $table="yh";
       public function  zuce()
	{
		
        return $this->fetch();
	}
 // 		public function list()
 // 	{
	// 	$date = UserModel::all();
	// 	$this->assign('date',$date);
 // 		return $this->fetch();
	// }
 	
   
	//新增用户方法
    public function  insert()
	{
      $data = input('post.');
    //调用验证规则
      $val = new YhValidate();
      if(!$val->check($data))
        {
        	$this->error($val->getError());
        	exit;
        }
      $yh = new YhModel($data);
      $result = $yh->where('binary name =:name ',['name'=>$data['name']])->find();   
      if($result){
          $this->error('用户名已存在');
         }
      $ret = $yh->allowField(true)->save();
       
      if($ret){
        	$this->success('注册成功','Index/denglu');
         }else
        {
        	$this->error('注册失败');
        }
	}
public function  yh()
	{
        return $this->fetch();
	}
  public function find()
    {
        return $this->fetch();
    }
 public function findcheck()
    {
        $content=input('post.');
        // dump($content);
         $val = new YhValidate();
        if(!$val->check($content))
        {
            $this->error($val->getError());
            exit;
        }
        $ret=db('yh')->where('name',$content['name'])->whereOr('email',$content['email'])->whereOr('xm',$content['xm'])->find();
      
        if(!$ret){
            $this->error('用户不存在');
        }else{
if($content['name']==$ret['name']&&$content['email']==$ret['email']
    ||$content['name']==$ret['name']&&$content['xm']==$ret['xm']
    || $content['email']==$ret['email']&&$content['xm']==$ret['xm'])
{
    $password=md5($content['password']);
    $result=db('yh')->where('yhid',$ret['yhid'])->update(['password' => $password]);
   if($result){
    $this->success('修改成功','Index/denglu');
        }
        else{
            $this->error('信息匹配错误');
        }
   }
}
    }
    public function manage(){
       $name=input('param.');
       
      $ret= db('yh')->where('yhid',$name['id'])->find();
     
      if($ret['image']){
        $image1= db('yh')->where('yhid', $name['id'])->find();
       $result= db('yh')->where('yhid',$name['id'])->update(['image' => null]);
       if($result){


           
       if(!$image1['image']==null){
$image1=substr($image1['image'],-46);
              $image1= ROOT_PATH . 'public' . DS . 'static'.$image1;
               $image1= str_replace("\\","/",$image1);

               unlink( $image1);
                }



        $this->success('恢复成功','admin/Book/bookjia');
        }
        else{
            $this->error('恢复失败');
        }

      } else{
            $this->error('已恢复');
        }
    }
     public function delet(){
        $name=input('param.');
      
       $content= db('yh')->where('name',$name['name'])->find();
        if($content){
               $ret=db('ushelf')->where('nameid',$content['yhid'])->where('bookid',$name['bookid'])->delete();
               if($ret){
                   $this->success('下架成功','admin/Book/bookjia');
        }
        else{
            $this->error('下架失败');
        }
        }
        else{
   $content= db('user')->where('name',$name['name'])->find();
   
           $ret=db('ushelf')->where('userid',$content['userid'])->where('bookid',$name['bookid'])->delete();
               if($ret){
                   $this->success('下架成功','admin/Book/bookjia');
        }
        else{
            $this->error('下架失败');
        }  
        }
    }
}
	