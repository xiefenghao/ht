<?php
namespace app\admin\validate;
use think\Validate;

class User extends Validate
{
	protected $rule = [
            'name'=>'require|min:2',
            //密码必须填写，至少8位，与repassword一样
            'password'=>'require|min:6|confirm:repassword',
           // 'xm'=>'require|min:2',
            'email' => 'require|email',
             
	];
	protected $message = [
          'name.require'=>'用户名不能为空',
          'name.min'=>'用户名长度不能少于2位',
          'password.require'=>'密码不能为空',
          'password.min'=>'密码长度不能少于6位',
          'password.confirm'=>'两次密码不一致',
        
          'email.require'=>'邮箱不能为空',
          'email' => '邮箱格式错误',
	];
}