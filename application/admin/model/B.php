<?php 
namespace app\admin\model;
use think\Model;


class B extends Model
{
   protected $auto = ['ip'];
   protected  function setIpAttr()
   {
   	return request()->ip();
   }
   
 
}