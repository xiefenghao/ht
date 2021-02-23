<?php
namespace  app\index\controller;
use think\Controller;
use app\index\model\Booka as BookaModel;

use app\index\validate\Booka as BookaValidate;


class Booka extends Controller
{
	public function yhsc()
  {
  	$id=session('yhid');
  	// dump($id);
  	if(!$id){
  		$this->error('请先登陆','index/Index/denglu');
  	}
  	return $this->fetch();
  }
public function bookadd()
  {
  	// $name=session('name');
  	// dump($name);
  	$id=session('yhid');
  	
  	// $yhid=db('yh')->field('yhid')->where('name',$name)->find();
  
         $date = input('post.');
			
         $val = new BookaValidate();

        if(!$val->check($date))
        {
        	$this->error($val->getError());
        	exit;
        }
	  
	     $result = db('b')->where('name',$date['name'])->find();
	     $result1 = db('booka')->where('name',$date['name'])->find();
	     // dump($result);
	     if($result||$result1){
      
       $this->error('该书已存在');
     
     }






			$file1 = request()->file('file');
			$num =count($file1);
			 // dump($file1);
			 // var_dump($num);
			if($num==2){
			//图片文件同时上传
			foreach ($file1 as $file) {
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			// dump($info);
			if($info){
	
				$content[]= 'http://127.0.0.1/tp/' .'public' . DS . 'uploads'.'/'.$info->getSaveName();
				
			
			 }
			
			}
			 var_dump($content);
	            $date['image'] = $content[0];
	  			$date['content'] = $content[1];
	  			 // dump($date);
			}
			else if($num==1){
			//只文件上传
			   foreach ($file1 as $file) {  
			   $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
                  if($info){
                  $content= 'http://127.0.0.1/tp/' .'public' . DS . 'uploads'.'/'.$info->getSaveName();
                  	// var_dump($content);	
                  	$date['content'] = $content;
			}
		}
	}
		
		//     else {
		// // 上传失败获取错误信息
		// 	   $this->error('请选择上传文件');  
		// 	}
			

			// dump($date);
			
			$date['yhid']=$id;
				 // dump($date); 	 
           $ret=  db('booka')->insert($date);


				  // $userId =$b->allowField(true)->getLastInsID();
				  // dump($userId);
				 
 			// $ret =db('nr')->data(['id'=>$userId,'nr'=>$content])->insert();
 			// dump($ret);
 //            Db::table('think_b')->where('id',$userId)->find();





            if($ret){
            	$this->success('新增书籍成功','Index/index');
            }
            else
        {
         	$this->error('新增书籍失败');
         }
     
    
		}}