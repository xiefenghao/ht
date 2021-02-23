<?php 
namespace app\index\model;
use think\Model;;


class Yh extends Model
{
   protected $auto = [ 'password'];

   protected function setPasswordAttr($value)
   {
   	return md5($value);
   }

   
}