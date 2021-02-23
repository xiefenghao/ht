<?php
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\User;
use app\admin\validate\Yh as YhValidate;

class Index extends Controller
{
	
	public function  yh()
	{

        return $this->fetch();
	}
 public function  indexb()
    {
   $name=session('name');
         return $this->fetch();
    }
  public function check()
  {
    $date = input('post.');
   
     $val = new YhValidate();

        if(!$val->check($date))
        {
          $this->error($val->getError());
          exit;
        }
     $user =new User();
     $result = $user->where('binary name =:name ',['name'=>$date['name']])->find();
    
     if($result){
      if($result['password'] === md5($date['password']))
      {
         session('userid',$result['userid']);
        session('name',$result['name']);
      
        
         
      } else{
        $this->error('密码不正确');
       }
     }else{
      $this->error('用户名不存在');
     }
if(captcha_check($date['code'])){
   $this->success('验证码正确，恭喜登陆','User/index');
}else{
  $this->error('验证码不正确');
}

  }

}