<?php
namespace  app\admin\controller;
use  app\admin\controller\Base;
use  Session;
//判断引用
 use app\admin\model\User as UserModel;
 use app\admin\validate\User as UserValidate;
 use app\admin\validate\Book as BookValidate;

class User extends Base
{
	 protected $table="user";
   public function   bdate(){
    $date=input('param.');
 
 $ret=db('b')->field('id,content')->where('id',$date['id'])->find();
 if($ret['content']==null){
  $this->error('内容可能不存在');
 }
   $this->assign('data',$ret['id']);
     return $this->fetch();
   }

   public function   bidate(){
 $date=input('param.');

 $ret=db('b')->field('content')->where('id',$date['id'])->find();
 if($ret['content']==null){
  $this->error('内容可能不存在');
 }
   $filename=$ret['content'];
     
              $filename = substr($filename,26);
               $filename= 'E:\wamp64\www\tp\public'.$filename;

        
 $ss=file_get_contents($filename);
  $encode1 = mb_detect_encoding( $date['text'], array('ASCII','CP936','GB2312','GBK','UTF-8'));

   if(!($encode1=="UTF-8")){
  $date['text'] = iconv("gb2312", "$encode1//IGNORE",$date['text']);
   }
//   $date['text'] = str_replace("\n","<br>",$date['text']);
//       echo ($date['text']);
 $encode = mb_detect_encoding($ss, array('ASCII','GB2312','GBK','UTF-8'));

//   if(!($encode=="UTF-8")){
  $date['text'] = iconv("UTF-8", "$encode//IGNORE",$date['text']);
//   }
//   $date['text'] = str_replace("\n","<br>",$date['text']);
//       echo ($date['text']);
    
 file_put_contents( $filename,$ss.$date['text']); // dump($handle);
  $this->success('更新成功','admin/User/book');

   }

   public function   ckan(){
    
    $date=input('param.');
    // dump($date);
    $ret=db('booka')->field('content')->where('id',$date['id'])->find();
     // dump($ret);
    if($ret!=null){
$abc=substr($ret['content'],-3);

if($abc!='txt'){
  $this->error('格式不符合');
}
      $content1 = file_get_contents($ret['content']);
        // echo ($content1);
        
       $encode = mb_detect_encoding($content1, array('ASCII','GB2312','GBK','UTF-8'));
  if(!($encode=="UTF-8")){
 $content1 = iconv("gb2312", "UTF-8//IGNORE",$content1);
  }
  $content1 = str_replace("\n","<br>",$content1);
      echo ($content1);
    }
    else{
    $ret=  db('b')->field('content')->where('id',$date['id'])->find();
      $abc=substr($ret['content'],-3);

if($abc!='txt'){
  $this->error('格式不符合');
}
      $content1 = file_get_contents($ret['content']);
        // echo ($content1);
        
       $encode = mb_detect_encoding($content1, array('ASCII','GB2312','GBK','UTF-8'));
  if(!($encode=="UTF-8")){
 $content1 = iconv("gb2312", "UTF-8//IGNORE",$content1);
  }
  $content1 = str_replace("\n","<br>",$content1);
      echo ($content1);
    }
     // $content1 = file_get_contents($date);
     // dump($content);
   }
   public function  yhsc()
  {
        $data = db('booka')->paginate(5);
        // dump($data);

        $this->assign('data',$data);
         return $this->fetch();
  }
  public  function tysc(){
    $date =input('param.');
    // dump($date);
      $id=$date['id'];
     // dump($id);
     $data=db('booka')->field('name,zz,type,jj,image,yhid,content')->where('id',$id)->find();
     // dump($data);
$abc=substr($data['content'],-3);
// dump($abc);
if($abc!='txt'){
  $this->error('格式不符合');
}
  $ret=db('b')->where('name',$data['name'])->find();
  if ($ret) {
    $this->error('书籍已存在');
  }
     $ret=db('b')->insert($data);
     $ret=db('booka')->where('name',$data['name'])->delete();
     $this->success('上传成功','admin/User/yhsc');
  }
  //删除用户上传书籍
  public  function delyhsc(){
    $date =input('param.');
      $id=$date['id'];
     // dump($id);
     $path =db('booka')->field('image,content')->where('id',$id)->find();
     // dump($path);
       
     $path= str_replace("\\","/",$path);
       
      //  $image1=substr($path['image'],-46);
      // $content=substr($path['content'],-46);
      //  $image= ROOT_PATH . 'public' . DS . 'uploads'.$image1;
      //  $content= ROOT_PATH . 'public' . DS . 'uploads'.$content;
       
     $ret= db('booka')->where('id',$id)->delete();
      if(!$path['image']==null){
         $image1=substr($path['image'],-46);
            $image= ROOT_PATH . 'public' . DS . 'uploads'.$image1;
            unlink($image);
      }
if(!$path['content']==null){
      $content=substr($path['content'],-46);
       $content= ROOT_PATH . 'public' . DS . 'uploads'.$content;
       
            unlink($content);
      }
     if($ret){
     
   
       $this->success('删除成功','admin/User/yhsc');
     }
  }
public function  plun()
  {
        $data = db('plun')->paginate(10);
        // dump($data);

        $this->assign('data',$data);
         return $this->fetch();
  }
  public function pldel(){
    
    $id=input('param.');dump($id);
  $dd=input('post.');dump($dd);
      $ret= db('plun')->where('id',$id['id'])->update(['content' => $id['content']]);
       if($ret){
      $this->success('修改成功','admin/User/plun');
     }
     else{
       $this->error('修改失败');
     }
  }
  public function  uppl()
  {
        $name=input('param.');
     
      $ret= db('plun')->where('id',$name['id'])->find();
      
      $this->assign('data',$ret);
         return $this->fetch();
  }
  public function  delplun()
  {
       $name=input('param.');
       // dump($name);
            $ret= db('plun')->where('id',$name['id'])->delete();
             if($ret){
      $this->success('删除成功','admin/User/plun');
     }
     else{
      $this->success('weizhi','admin/User/plun');
     }
  }
       public function  index()
       {
	 
     $name=session('name');
		
      $data = db('user')->paginate(8);
        $this ->assign('data',$data);
        return $this->fetch();
	}
 
 	
   public function  add()
	{
     $name=session('name');
      $ret =db('user')->field('name')->where('userid',2)->find();
    if($name==$ret){
      return $this->fetch();
    }
      else{
        $this->error('没有权限');
      }  
	}
	//新增管理员方法
    public function  insert()
	{
       $data = input('post.');
    
        $val = new UserValidate();
//

        if(!$val->check($data))
        {
        	$this->error($val->getError());
        	exit;
        }
       
        
        $user = new UserModel($data);
       $result = $user->where('name',$data['name'])->find();
    
     if($result){
             $this->error('用户名已存在');
     }
        $ret = $user->allowField(true)->save();
       
        if($ret){
        	$this->success('新增管理员成功','Index/yh');
        }else
        {
        	$this->error('新增管理员失败');
        }
	}

 public function delete()
    {
        session(null);
       $this->success('退出成功','index/Index/index');
    }
     public function delete1()
    {
        session(null);
       $this->success('退出成功','admin/Index/yh');
    }
    public function  show()
    {
      $data = db('yh')->paginate(10);
     
        $this ->assign('data',$data);
        return $this->fetch();
        
    }
 public function  chong()
    {
      $date =input('param.');
      $id=$date['yhid'];
     $password=md5(123456);
    // dump($id);
     $ret= db('yh')->where('yhid',$id)->update(['password' => $password]);
     
     if($ret){
       session($date['yhid'],null);
      $this->success('密码重置成功','admin/User/show');
     }
     else{session('yhid', null);
       
      $this->success('密码已重置','admin/User/show');
     }
    }
 public function  del()
    {
      $date =input('param.');
      $id=$date['id'];
    
     $path =db('b')->field('image,content')->where('id',$id)->find();
    
     $path= str_replace("\\","/",$path);
       if($path['image']){
          $image1=substr($path['image'],-46);
                $image= ROOT_PATH . 'public' . DS . 'uploads'.$image1;
                unlink($image);
       }
     
      $content=substr($path['content'],-46);
 
       $content= ROOT_PATH . 'public' . DS . 'uploads'.$content;
       
    
     $ret= db('b')->where('id',$id)->delete();
     
     if($ret){
   
        
      
          if($content){
             unlink($content);
          }
        
       db('dian')->where('bookid',$id)->delete();
        db('plun')->where('bookid',$id)->delete();
   
       $this->success('删除成功','admin/User/book');
     }
    
    }
    public function  book()
    {
      $data = db('b')->paginate(5);
    
      $this ->assign('data',$data);
        return $this->fetch();
        
    }
    public function  bookdate()
    {
  $date =input('param.');
  // dump($date);
      $id=$date['id'];
     
     $ret= db('b')->where('id',$id)->find();
     // dump($ret);
        $this ->assign('data',$ret);
        return $this->fetch(); 
    }
     public function  bookup()
    {
 
    $date =input('param.');
    // dump($date);
$file = request()->file('image');
     // dump($file);
// 移动到框架应用根目录/public/uploads/ 目录下
if(!$file==null){
  // $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
  $info = $file->validate(['size'=>3567822,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
      if($info){
  
        $image= 'http://127.0.0.1/tp/' .'public' . DS . 'uploads'.'/'.$info->getSaveName();
       }
     else{

// 上传失败获取错误信息
echo $file->getError();
 $this->error();
}
}
else{
  $image =null;
}
       // dump($image);
$val = new BookValidate();
//

        if(!$val->check($date))
        {
          $this->error($val->getError());
          exit;
        }
     
      $id=$date['id'];
      $ret = db('b')->field('name')->where('id',$id)->find();
      
      
      if(!($date['name']==$ret['name'])){


       $result1 = db('b')->where('name',$date['name'])->find();
        
      
       if(!$result1==null){
      
       $this->error('该书名已存在');
     }
      else{
  
      $result = db('b')->where('id',$id)->find();
   
      if(!$image==null){
          $date['image']=$image;
        }else{
           $date['image']=$result['image'];
        }
      
       // dump($date['image']);
         $date['content']=$result['content'];
         
    $result=db('b')->where('id',$id)->update([
'name' => $date['name'],
'zz' => $date['zz'],
'type' => $date['type'],
'jj' => $date['jj'],
'image'=> $date['image'],
]);
    if($result){
      
        $this->success('修改成功','admin/User/book');
     }
     }
     }
    
    }
    public function adminup()
    {
       $data=input('param.');
      
 $name=session('name');
 
      $id=$data['id'];
      $result = db('user')->where('userid',$id)->find();
     $ret =db('user')->field('name')->where('userid',2)->find();
      
      if($name==$result['name']||$name==$ret){
         $this->assign('date',$result);
      return $this->fetch(); 
      }
      else{
          $this->error('不能修改其他管理员信息');
      }
     
    }//管理员修改信息
       public function admindate()
    {
       $date=input('post.');
    
      $val = new UserValidate();
//

        if(!$val->check($date))
        {
          $this->error($val->getError());
          exit;
        }
      $id=session('userid');
       // dump($date);
      $result = db('user')->where('userid',$id)->find();
       // dump($result);
       // dump(($result['name']==$date['name']));
if(!($result['name']==$date['name'])){
 $result1 = db('user')->where('name',$date['name'])->find();
  dump($result1);
  if($result1){
           $this->error('用户名已存在');
         }
}
   $password=md5($date['password']);
       $ret=db('user')->where('userid',$id)->update([
'name' => $date['name'],
'email' => $date['email'],
'password' => $password,
]);
       if($ret){
        session(null);
         $this->success('修改成功','admin/User/index');
       }
       else{
         $this->error('修改失败');
       }

  

        
   

     
   
      
     
    }
    //用户删除
    public function delyh()
    {
      $name=session('name');
      if($name=='xfhxfh'){
 $data=input('param.');
 
  $ret= db('yh')->where('yhid',$data['yhid'])->delete();
     
     if($ret){

      $this->success('删除成功','admin/User/show');
     }
      }
      else{
       $this->error('权限不够'); 
      }
    }
    public function bdsc()
    {
      $ret=db('delete')->paginate(10);
      $this->assign('date',$ret);
    return $this->fetch();
    }
    public function bd()
    {
       $date =input('param.');
      $ret=db('delete')->where('id',$date['id'])->delete();;
      if($ret){

      $this->success('删除成功','admin/User/bdsc');
     }
    }
}
	