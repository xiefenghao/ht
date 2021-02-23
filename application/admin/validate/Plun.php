<?php
namespace app\admin\validate;
use think\Validate;

class plun extends Validate
{
	
	protected $rule =[
            'content'=>'require|min:1|max:45',
            
             

             
	];
	protected $message =[
          'content.require'=>'评论不能为空',
          'content.min'=>'评论长度不能少于1位',
          'content.max'=>'评论长度不能多于45位',
         
           
        
	];
}