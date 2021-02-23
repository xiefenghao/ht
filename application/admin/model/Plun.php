<?php 
namespace app\admin\model;
use think\Model;


class Plun extends Model
{
   protected $auto = ['ip'];
   protected  function setIpAttr()
   {
   	return request()->ip();
   }
   
 
}