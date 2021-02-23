<?php
namespace  app\admin\controller;
use think\Controller;
use app\admin\model\B ;

use think\Db;
use app\admin\validate\Book as BookValidate;


class Book extends Controller
{
     public function dianzan()
     {
      $name=session('name');
   $date =input('param.');
       // dump($date);

      $bid = db('b')->field('id')->where('name',$date['bookname'])->find();
      $bookid=$bid['id'];
       // dump($bookid);  
   if(!$name){
     $this->error('请先登陆','index/Index/denglu');
  }
  else{
$content = db('yh')->field('yhid')->where('name',$name)->find();
 if($content){
  $yhid=$content['yhid'];
                $ret= db('dian')->where('bookid',$bookid)->select();
        // dump($ret);
        // echo 99;
        $yh = array_column($ret,'yhid');
        // dump($yh);

if(in_array($yhid,$yh)){
   $this->error('你已经点赞过了');
}else{
  $result=db('dian')->data(['yhid'=>$yhid,'bookid'=>$bookid])->insert();
       if($result){
          $num=db('b')->field('zan')->where('id',$bookid)->find();


$num1= $num['zan']+1;

db('b')->where('id',$bookid)->update(['zan' => $num1]);
           $this->error('点赞成功');
          }
          }
          
          }
       
     else{
      $content = db('user')->field('userid')->where('name',$name)->find();
       $userid=$content['userid'];
       // dump($userid);
       // echo 99;
        $ret= db('dian')->where('bookid',$bookid)->select();
        // dump($ret);
        // echo 99;
        $user = array_column($ret,'userid');
        // dump($user);

if(in_array($userid,$user)){
   $this->error('你已经点赞过了');
}else{
  $result=db('dian')->data(['userid'=>$userid,'bookid'=>$bookid])->insert();
       if($result){
        $num=db('b')->field('zan')->where('id',$bookid)->find();


$num1= $num['zan']+1;

db('b')->where('id',$bookid)->update(['zan' => $num1]);
           $this->error('点赞成功');
          }
          }
    

     }
     
    

        }
 }
    public function  index()
    {
   $id=session('userid');
  
   if(!$id){
    $this->error('请先登陆','index/Index/denglu');
  }else{
     return $this->fetch();
  }
        
    }
     public function  book()
    {
      $data = db('b')->paginate(8);
		
   		$this ->assign('data',$data);
        return $this->fetch();
        
    }
    public function type()
    {
    	$date =input('param.');
       $b =new b($date);
	     $content = $b->where('type',$date['type'])->paginate(8);
       $this ->assign('data',$content);
        return $this->fetch();
    }
     public function shujia()
    {
    	
    	// dump(session('name'));
    	$name=session('name');
    	// dump($name);
    	if($name){
$content = db('yh')->field('yhid')->where('name',$name)->find();
 if($content){
 	$yhid=$content['yhid'];
 	$name =input('param.');
     // dump($name);
    	$b =new b($name);
	     $content = $b->field('id')->where('name',$name['bookname'])->find();

$name=$name['bookname'];
$bookid= $content['id'];
$result =db('ushelf')->where(['nameid'=>$yhid,'bookid'=>$bookid])->find();

if($result){

	 $this->success('书籍已经加入书架','admin/Book/txt?name='.$name);
	
}
else{
	$ret =db('ushelf')->data(['nameid'=>$yhid,'bookid'=>$bookid])->insert();
if($ret){
	 $this->success('加入书架成功','admin/Book/txt?name='.$name);
}
 }
 return $this->fetch();
}
 else{
 	$content = db('user')->field('userid')->where('name',$name)->find();
 		$userid=$content['userid'];
 		$name =input('param.');
     // dump($name);
    	$b =new b($name);
	     $content = $b->field('id')->where('name',$name['bookname'])->find();

$name=$name['bookname'];
$bookid= $content['id'];
$result =db('ushelf')->where(['userid'=>$userid,'bookid'=>$bookid])->find();

if($result){

	 $this->success('书籍已经加入书架','admin/Book/txt?name='.$name);
	
}
else{
	$ret =db('ushelf')->data(['userid'=>$userid,'bookid'=>$bookid])->insert();
if($ret){
	 $this->success('加入书架成功','admin/Book/txt?name='.$name);
}
 }
 return $this->fetch();
}
 }
 
 
 
    	
    	


    	else{
    		$this->error('请先登陆','index/Index/denglu');
    	}
    }
    public function bookjia()
    {
    	$name=session('name');
    	// dump($name);
    	if($name){
$content = db('yh')->field('yhid')->where('name',$name)->find();
$yhid=$content['yhid'];
if($yhid)
{
$content=db('ushelf')->where(['nameid'=>$yhid])->select();

if($content)
{
foreach ($content as $key => $value) {
$arr[] = $value['bookid'];
}

$where['id'] = ['in', $arr];
$book=db('b')->where($where)->select();
   	
    $image=db('yh')->where('yhid',$yhid)->find();
    // dump($image);
    // echo 1;
    if($image){
       $bj=$image['image'];
    
    }
   // else{
   //  // $bj='/20190406/86efbff154fe04098f0d1897d486c6d2.jpg';
   // }
   // dump($bj);
    $this->assign('bj',$bj); 
   
    $this->assign('data',$book); 
     return $this->fetch(); 
}
else{
   $image=db('yh')->where('yhid',$yhid)->find();
    // dump($image);
    
    if($image){
       $bj=$image['image'];
    
    }
   
    // $bj='/20190406/86efbff154fe04098f0d1897d486c6d2.jpg';
   
   // dump($bj);
    $this->assign('bj',$bj); 
	$book=db('b')->where('name','2112')->select();
	// dump($book);
   $this->assign('bj',$bj);
	 $this->assign('data',$book); 
	 return $this->fetch(); 
}	
}
else{
		$content = db('user')->field('userid')->where('name',$name)->find();
 		$userid=$content['userid'];
 		$content=db('ushelf')->where(['userid'=>$userid])->select();
    // dump($content);
if($content)
{
foreach ($content as $key => $value) {
$arr[] = $value['bookid'];
}

$where['id'] = ['in', $arr];
$book=db('b')->where($where)->select();
    // dump($book);	

    $this->assign('data',$book); 
$bj='/20190406/86efbff154fe04098f0d1897d486c6d2.jpg';
   
  
    $this->assign('bj',$bj); 
     return $this->fetch(); 
}

}
}

else{
	 $this->error('请先登陆','index/Index/denglu'); 
	
}


}

     public function  sou()
    {
    	$name =input('get.');
    	
       
   $b =new b($name);
 $params = $this -> request -> param();
   $where['name|zz'] = array('like', "%{$name['name']}%");
  
      $content=$b->where($where) -> paginate(8,false,['query'=>request()->param()]);  
  
   $num=$b->where($where)->select();
     
      
       $this ->assign('data',$content);
            $this ->assign('num',count($num));
         return $this->fetch();



      
    	
    	}
    
 

     public function  shuji()
    {
    	$data = db('b')->paginate(8);
		// dump($data);
    	 // $image = \think\Image::open($date['image']); 
    	
   		$this ->assign('data',$data);
        return $this->fetch();
    }
    public function  txt()
    {
    	$name1=input('param.');
    	$name =input('post.');
     //  	 dump($name);
	    // dump($name1);
    	  if(!$name){
    	  	$name=$name1;}
    	 	 $b =new b($name);
    	  

    	  //获取id
    	  	$content=$b->where('name',$name['name'])->find();
    	   // dump($i);//	{"id":40}
    	  //Object获取id 数字
    	//   $id =$i->{"id"};
     // dump($id);
         $type=$content['type'];
         $text=$content['content'];
        
         $abc=substr($text,-3);
         if($abc!='txt'){
          $this->error('文件不存在');
         }
//          if($type=='文章'){
//           $text=$content['content'];
//           $text=$content['content'];
//           dump($text);

//            $conten = file_get_contents($text); 
//             echo mb_detect_encoding($text);
//             $encode = mb_detect_encoding($conten, array('ASCII','GB2312','GBK','UTF-8'));
//   if($encode!="UTF-8"){

//      // $data = mb_convert_encoding($conten ,'UTF-8' , $encode);
//  // $conten = iconv("gb2312", "UTF-8//IGNORE",$conten);
//      // dump($data);
//     // $outstr = mb_convert_encoding($conten,'UTF-8','ASCII');
//     // echo $outstr;
  
//     // iconv("utf8","gbk",$string)
    

//  $conten = iconv("ASCII", "UTF-8//IGNORE",$conten);
//   echo mb_detect_encoding($conten);
//   }
// $flash = $content; 
// $this->assign('flash',$flash);
// $this->assign('flas',$conten);
// return $this->fetch('fla');
//          }
    	
        $bookid= $content['id'];
        //书籍位置赋予f1
        $fl = $content['content']; 
        


      $content1 = file_get_contents($fl); 

 $encode = mb_detect_encoding($content1, array('ASCII','GB2312','GBK','UTF-8'));
  if(!($encode=="UTF-8")){
 $content1 = iconv("gb2312", "UTF-8//IGNORE",$content1);
  }
  //     $con=mb_convert_encoding($content1,"UTF-8","GBK");

 // $con = iconv("gb2312", "UTF-8//IGNORE",$content1);
  //      $con = iconv("utf-8","gb2312//IGNORE",$content1); 
         
       // $content1 = iconv("utf-8","gb2312//IGNORE",$content1); 
       // dump($content1);

      if(preg_match_all("/(\x{7b2c})(\s*)([\x{96f6}\x{4e00}\x{4e24}\x{4e8c}\x{4e09}\x{56db}\x{4e94}\x{516d}\x{4e03}\x{516b}\x{4e5d}\x{5341}\x{767e}\x{5343}}0-9]+)(\s*)([\x{56de}\x{7ae0}\x{8282}]+)/u",$content1,$matches)){
        //数组中取出一段
        
      $matches=array_slice($matches[0], 0,count($matches[0]));

$matches=array_unique($matches);

$matches=array_values(array_filter($matches));
        for ($i=0; $i <count($matches); $i++)
 
{
 
$j=$i+1;

 //第*章
if(isset($matches[$j]))
 
{
$pattern="#$matches[$i](.*)$matches[$j]#isU";
 
$arr[$i]=$pattern;
 
}
 
else
 
{
 //章节
$offset=count($arr);
// dump($offset);
$arr[$offset]="#$matches[$i](.*)[\w]#isU";

} 
}



}
 //移除数组第*章中重复的值

 $zhangjie=$arr;

 foreach ($arr as $key => $value)
 
{

 //执行匹配正则表达式
preg_match($value, $content1,$arr[$key]);
 //内容->arr

 unset($arr[$key][0]);

} 
// dump(end($arr)) ;
 // dump($arr) ;
static $bookContent=[];

foreach ($arr as $key => $value)
 
 { 

 if(isset($value[1]))
 {
  //echo 11;
 //   dump($value[1]);
  //章节名称
  // foreach ($variable as $key => $value) {
  //  # code...
  // }
   //查找字符串的首次出现
 $chaptername =strstr($value[1], "\n", true);

 $bookname=$chaptername;
 $zhang[]=$bookname;
 // echo $bookname;
 }
 else
 {
 
 $chaptername='哎呀没处理好';
 
 }
}

 // dump(count($zhangjie));

// $tet=$arr;
  // dump($tet);
 // echo " 1";
// $txt =$bookContent;
    // dump($txt);print_r($txt);
// foreach ($txt as $key => $value)
// {
// 　　echo $key;
// }
// dump($zhang);
  $content['content']=$content1;
  // echo 11;
  // dump($content);
  //dump($bookname);(最后一章章节名)
  //dijizhang
  
$number = range(1,count($zhangjie));
 // $q=end($zhang);
// echo substr($arr, -1);
//  $last=count($arr);
//  echo 789;
// dump($arr) ;
// dump($arr[190]);
//  strchr($content1,$q);
 $j=count($number);
  $w=count($zhang);
// dump($w);
 if($j>$w){
  for($i=$j-$w;$i>0;$i--){
     array_pop($number);
  }
 }else{
  for($i=$w-$j;$i>0;$i--){
     array_pop($zhang);
  }
 }
$arr=array_combine($number,$zhang);


$plun=db("plun")->where('bookid',$bookid)->select();
// dump($plun);
  $content1= array_column($plun, 'content');
  $a = array_column($plun, 'username');
  $b = array_column($plun, 'yhname');
    $a=array_filter($a);$b=array_filter($b);
  
  $pna=($a+$b);
 
  
if($pname=null){
  $pname=db('yh')->field('name')->where('yhid','$b')->find();
}
$plun1['name']=$pname;
$plun1['content']=$content1;
$pid=count($plun1['content']);
$plun1['time']=array_column($plun, 'time');
// dump($plun1);
$plunc=$plun1['content'];
$plunt=$plun1['time'];

krsort($plunc);
krsort($plunt);
krsort($pna);

 $this ->assign('plun',$plun1);
$this ->assign('pna',$pna);
 $dian=db('dian')->where('bookid',$bookid)->select();
 $numdian=count($dian);
 // dump($numdian);

//         dump($dian);
//         echo 99;
//         $yh = array_column($ret,'yhid');
//         dump($yh);

// if(in_array($yhid,$yh)){

// }
  $this->assign('dian',$numdian);
 $this->assign('plunc',$plunc);
 $this->assign('plunt',$plunt);
  $this->assign('pid',$pid);
  $this->assign('message',$content);
  $this->assign('num',$number);
  $this ->assign('name',$zhangjie);

  $this ->assign('z',$arr);
   // dump($bookContent);
  // 章节内容
      // $sh=action('flash',['mess'=>$bookContent]);
      // dump($sh);
   // $this->fetch('flash',['flash'=>$bookContent]);
        return $this->fetch();
   
      

       
 }
 public function flash()
  {
  	
 $date =input('param.');
  // dump($date);
  	$id=$date['id'];

//  if($id=-1||$id=$num){
// 	$this->error('myl','Book/txt');
// }else{}
    	$name =$date['name'];
//     	dump($name);
// dump($id);
    	  
    	 	 $b =new b($date);

    	  //获取id
    	  	$content=$b->where('name',$date['name'])->find();
    	   // dump($i);//	{"id":40}
    	  //Object获取id 数字
    	//   $id =$i->{"id"};
     // dump($id);
    	// dump($content);
    	$message=$content;
    	// dump($message);
	    	//书籍位置赋予f1
        $bookid= $content['id'];
	    	$fl = $content['content']; 
	    	


			$content1 = file_get_contents($fl); 

 $encode = mb_detect_encoding($content1, array('ASCII','GB2312','GBK','UTF-8'));
	if(!($encode=="UTF-8")){
 $content1 = iconv("gb2312", "UTF-8//IGNORE",$content1);
	}
	// 		 $con=mb_convert_encoding($content1,"UTF-8","GBK");

 // $con = iconv("gb2312", "UTF-8//IGNORE",$content1);
	// 		  $con = iconv("utf-8","gb2312//IGNORE",$content1); 
			   
			 // $content1 = iconv("utf-8","gb2312//IGNORE",$content1); 
			// dump($content1);
			if(preg_match_all("/(\x{7b2c})(\s*)([\x{96f6}\x{4e00}\x{4e24}\x{4e8c}\x{4e09}\x{56db}\x{4e94}\x{516d}\x{4e03}\x{516b}\x{4e5d}\x{5341}\x{767e}\x{5343}}0-9]+)(\s*)([\x{56de}\x{7ae0}\x{8282}]+)/u",$content1,$matches)){
				//数组中取出一段
				
			$matches=array_slice($matches[0], 0,count($matches[0]));
			 

$matches=array_unique($matches);
$matches=array_values(array_filter($matches));
				for ($i=0; $i <count($matches); $i++)
 
{
 
$j=$i+1;

 //第*章
if(isset($matches[$j]))
 
{
$pattern="#$matches[$i](.*)$matches[$j]#isU";
 
$arr[$i]=$pattern;
 
}
 
else
 
{
 //章节
$offset=count($arr);
// dump($offset);
$arr[$offset]="#$matches[$i](.*)[\w]#isU";

} 
}



}
 //移除数组第*章中重复的值

$ret=array_unique($arr);
 $zhangjie=$ret;


//  dump(count($zhangjie));
// echo 99;
foreach ($arr as $key => $value)
 
{
 //执行匹配正则表达式
preg_match($value, $content1,$arr[$key]);
 //内容->arr

unset($arr[$key][0]);
 
   // dump($arr[1]);
   // echo 22;
 // dump($value);

} 
 // dump($arr);
 
static $bookContent=[];

foreach ($arr as $key => $value)
 
 { 

 if(isset($value[1]))
 {
 	//echo 11;
 // 	dump($value[1]);
 	//章节名称
 	// foreach ($variable as $key => $value) {
 	// 	# code...
 	// }
 	 //查找字符串的首次出现
 $chaptername =strstr($value[1], "\n", true);
// dump(count($value));
 $bookname=$chaptername;
 $zhang[]=$bookname;
 // echo $bookname;
 }
 else
 {
 
 $chaptername='哎呀没处理好';
 }

// $name=$zhangjie.$bookname;
// dump($name);
 @$bookContent[$matches[$key].$chaptername]=$value[1];
 // dump( @$bookContent[$matches[$key].$chaptername]=$value[1]); 
 //unset — 释放给定的变量
 unset($bookContent[$key]);


// dump($bookContent);
}






// $tet=$arr;
  // dump($tet);
 // echo " 1";
// $txt =$bookContent;
    // dump($txt);print_r($txt);
// foreach ($txt as $key => $value)
// {
// 　　echo $key;
// }

 	$content['content']=$content1;
 	// echo 11;
 	  // dump($content1);
 	//dump($bookname);(最后一章章节名)
 	//dijizhang
 	$number = range(1,count($zhangjie));

 $last=count($arr);

  $q=end($zhang);
 


$count=count(($number));
//  	dump($bookContent);
 $j=count($number);
  $w=count($zhang);
  
 if($j>$w){
  for($i=$j-$w;$i>0;$i--){
     array_pop($number);
  }
 }else{
  for($i=$w-$j;$i>0;$i--){
     array_pop($zhang);
  }
 }
 	$arr=array_combine($number,$zhang);
 	// echo (count($bookContent));
 	// print_r(array_keys($bookContent));
 	// echo array_keys($bookContent)[$id];
 	 if($id==-1||$id==$count){
  	 	$this ->assign('use',$content);
 	$this->assign('message',$message);
 
 	$this->assign('z',$arr);$this ->assign('id',$id);
  $plun=db("plun")->where('bookid',$bookid)->select();


  $content1= array_column($plun, 'content');
//   $a = array_column($plun, 'userid');
// $b=array_column($plun, 'yhid');
// // dump($a);dump($b);
//   $pname=db('user')->field('name')->where('userid','in',$a)->select();
// // dump($pname);
// if($pname=null){
//   $pname=db('yh')->field('name')->where('yhid','$b')->find();
// }
$plun=db("plun")->where('bookid',$bookid)->select();

  $content1= array_column($plun, 'content');
  $a = array_column($plun, 'username');
  $b = array_column($plun, 'yhname');
    $a=array_filter($a);$b=array_filter($b);
  
  $pna=($a+$b);
 
  
if($pname=null){
  $pname=db('yh')->field('name')->where('yhid','$b')->find();
}
$plun1['name']=$pname;
$plun1['content']=$content1;
$pid=count($plun1['content']);
$plun1['time']=array_column($plun, 'time');
// dump($plun1);
$plunc=$plun1['content'];
$plunt=$plun1['time'];
 krsort($plunc);
krsort($plunt);
krsort($pna);
 $this ->assign('plun',$plun1);
$this ->assign('pna',$pna);
 $dian=db('dian')->where('bookid',$bookid)->select();
 $numdian=count($dian);
 


  $this->assign('dian',$numdian);
 $this->assign('plunc',$plunc);
 $this->assign('plunt',$plunt);
 $this ->assign('pid',$pid);
//hebing

  $this ->assign('plunc',$plunc);
    $this ->assign('plunt',$plunt);
  	 return $this->fetch('txt');

  }
  if($id==($count-1)){
    $content=strchr($content1,$q);
  }
  else{
      $content=$bookContent[ array_keys($bookContent)[$id]];
       // dump($content);
  }
// $content=trim($content);
//   dump($content);
$jie=array_keys($bookContent)[$id];
 $kjj= substr($jie,0,strpos($jie, '章'));





$resultaa = substr($jie,strripos($jie,'章')+1);
   // dump($resultaa);
   //去掉前3个
$str2 = substr($resultaa,3);
// dump($str2);

 $nam=array_keys($bookContent)[$id];
 $content=str_replace("$str2",'',$content);
  // $content=str_replace(array_keys($bookContent)[$id],'',$content);
    $content = str_replace("\n","<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content);
    // $a=preg_replace('/\n|\r\n/','bj',$content);
    // dump($a);
// dump($content);


// dump($content);
// echo 99;
// // dump(trim($stra,"<br>") ); 
//     dump($nam);
// dump(substr_replace($name ,"", -1));
 	$this ->assign('use',$content);
 	$this->assign('message',$message);
 	$this->assign('zhangjie',$nam);
 	$this->assign('z',$arr);
 	$this ->assign('id',$id);
       


 return $this->fetch();
  }
  public function bookadd()
  {
         $date = input('post.');
			
         $val = new BookValidate();

        if(!$val->check($date))
        {
        	$this->error($val->getError());
        	exit;
        }
	     $b =new b($date);
	     $result = $b->where('name',$date['name'])->find();
	     // dump($result);
	     if($result){
      
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
			if($info){
	
				$content[]= 'http://127.0.0.1/tp/' .'public' . DS . 'uploads'.'/'.$info->getSaveName();
				
			
			}

			}
	            $date['image'] = $content[0];
	  			$date['content'] = $content[1];
	  			// dump($date);
			}else if($num==1){
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
			

			
			
			
				 	 
            $b =new b($date);
     
    
  
				
            $ret=  $b->allowField(true)->save();


				  // $userId =$b->allowField(true)->getLastInsID();
				  // dump($userId);
				 
 			// $ret =db('nr')->data(['id'=>$userId,'nr'=>$content])->insert();
 			// dump($ret);
 //            Db::table('think_b')->where('id',$userId)->find();
            if($ret){
            	$this->success('新增书籍成功','User/index');
            }
            else
        {
         	$this->error('新增书籍失败');
         }
     
    
		}
  


}
