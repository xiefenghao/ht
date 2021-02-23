<?php 
namespace app\admin\model;
use think\Model;


class Yh extends Model
{
	
   protected $auto = ['ip', 'password','repassword'];
   protected  function setIpAttr()
   {
   	return request()->ip();
   }
   
   protected function setPasswordAttr($value)
   {
   	return md5($value);
   }
  protected function setRepasswordAttr($value)
   {
   	return md5($value);
   }
}