<?php
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\Plun ;

use think\Db;

use app\admin\validate\Plun as PlunValidate;

class Pinglun extends Controller
{
public function  plun()
    {
   $name=session('name');
   // dump($name);
  
    $time=date('Y-m-d H:i:s',time());
   // dump($time);
   $id=input('param.');
   // dump($id);
   // echo 11;
   if(!$name){
   	$this->error('请先登陆','index/index/denglu');
   }
       
         $val = new PlunValidate();

        if(!$val->check($id))
        {
        	$this->error($val->getError());
        	exit;
        }
$content = db('yh')->field('yhid')->where('name',$name)->find();
 if($content){
 	$yhname=$name;
 	
 		$plun = new Plun;
	$plun->data(['yhname'=>$yhname,'bookid'=>$id['id'],'content'=>$id['content'],'time'=>$time]);
$ret =$plun->save();
 		if($ret){
      $num=db('b')->field('plun')->where('id',$id['id'])->find();
// dump($num);

$num1= $num['plun']+1;
// dump($num1);
db('b')->where('id',$id['id'])->update(['plun' => $num1]);
 			 $this->success('留言成功','admin/Book/txt?name='.$id['name']);
 		}
 		else{
 			$this->error();
 		}
    }
    else{
    
    	$username=$name;
	
	$plun = new Plun;
	$plun->data(['username'=>$username,'bookid'=>$id['id'],'content'=>$id['content'],'time'=>$time]);
$ret =$plun->save();
	// $ret =db('plun')->data(['userid'=>$userid,'bookid'=>$id['id'],'content'=>$id['content']])->save();
if($ret){
   $num=db('b')->field('plun')->where('id',$id['id'])->find();
// dump($num);

$num1= $num['plun']+1;
// dump($num1);
db('b')->where('id',$id['id'])->update(['plun' => $num1]);
 			$this->success('留言成功','admin/Book/txt?name='.$id['name']);
 		}
	else{
 			$this->error(sassaas);
 		}
    }

}
// public function show(){

// }


}