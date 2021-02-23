<?php
namespace app\index\validate;
use think\Validate;

class Yh extends Validate
{
	protected $rule =[
            'name'=>'require|min:4|max:16',
            //密码必须填写，至少8位，与repassword一样
            'password'=>'require|min:6|confirm:repassword',
            'xm'=>'require|min:2|max:8',
             'email' => 'require|email',
             
	];
	protected $message =[
          'name.require'=>'用户名不能为空',
          'name.min'=>'用户名长度不能少于4位',
          'name.max'=>'用户名长度不能多于16位',
          'password.require'=>'密码不能为空',
          'password.min'=>'密码长度不能少于6位',
          'password.confirm'=>'两次密码不一致',
          'xm.require'=>'真实姓名不能为空',
          'xm.min'=>'真实姓名长度不能少于2位',
          'xm.max'=>'真实姓名长度不能多于8位',
          'email.require'=>'邮箱不能为空',
          'email' => '邮箱格式错误',
	];
}//alpha  是否为字母
// alphaNum  是否为字母和数字
// alphaDash 是否为字母、数字，下划线_及破折号-
// number  是否为数字