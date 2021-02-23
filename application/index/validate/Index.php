<?php
namespace app\index\validate;
use think\Validate;

class Index extends Validate
{
	protected $rule =[
            'name'=>'require|min:1',
            'md5'=>'require',
            //密码必须填写，至少8位，与repassword一样
            'password'=>'require|min:6|confirm:repassword',
            
             
	];
	protected $message =[
          'name.require'=>'用户名不能为空',
          'name.min'=>'用户名长度不能少于2位',
          'password.require'=>'密码不能为空',
          'password.min'=>'密码长度不能少于6位',
          'password.confirm'=>'两次密码不一致',
          'md5.require'=>'原密码不能为空',
         
	];
}