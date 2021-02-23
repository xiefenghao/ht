<?php
namespace app\admin\validate;
use think\Validate;

class Book extends Validate
{
	protected $rule =[
            'name'=>'require|min:1|max:15',
            'zz'=>'require|min:1',
             'type'=>'require',
             'jj'=>'require|min:2|max:600',
             

             
	];
	protected $message =[
          'name.require'=>'书名不能为空',
          'name.min'=>'书长度不能少于1位',
          'name.max'=>'书长度不能多于15位',
          'zz.require'=>'作者不能为空',
          'zz.min'=>'作者长度不能少于1位',
           'type.require'=>'类型不能为空',
          'jj.require'=>'简介不能为空',
          'jj.min'=>'简介长度不能少于2位',
            'jj.max'=>'简介长度不能多于600位',
        
	];
}