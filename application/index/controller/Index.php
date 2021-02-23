<?php
namespace  app\index\controller;
use think\Controller;
use app\index\model\Yh;
 use app\index\validate\Index as IndexValidate;

class Index extends Controller
{
    public function tp(){
       return $this->fetch();
    }
    public function indexq(){
       return $this->fetch();
    }
    public function tpadd()
    {
     $id=session('yhid');
     // dump($id);
   $file = request()->file('image');
// 移动到框架应用根目录/public/uploads/ 目录下
if($file){
$info = $file->move(ROOT_PATH . 'public' . DS . 'static');
if($info){

       
        $getSaveName=str_replace("\\","/",$info->getSaveName());
         $image= '/'.$getSaveName;
            $image1= db('yh')->where('yhid', $id)->find();
           
       if(!$image1['image']==null){
$image1=substr($image1['image'],-46);
              $image1= ROOT_PATH . 'public' . DS . 'static'.$image1;
               $image1= str_replace("\\","/",$image1);

               unlink( $image1);
                }
      $ret=db('yh')->where('yhid', $id)->update(['image' => $image]);
      if($ret){
         $this->success('上传成功','admin/book/bookjia');
      }
        
}else{
// 上传失败获取错误信息
echo $file->getError();
}
// dump($image);
}
else{
   $this->error('没有图片');
}
}


    public function  denglu()
    {
        return $this->fetch();
    }
  public function check()
  {
    $date = input('post.');
   
    if($date['name']=='xadmin'&&$date['password']=='adminx'){
   $this->success('欢迎','admin/Index/yh');
}else{


     $yh =new Yh();
     $result = $yh->where('binary name =:name ',['name'=>$date['name']])->find();
     // dump($result);
     if($result){
      if($result['password'] === md5($date['password']))
      {
        
       
        session('yhid',$result['yhid']);
        session('name',$result['name']);
         $this->success('恭喜登陆','Index/index');
         
      } else{
       $this->error('密码不正确');
       }
     }else{
      $this->error('用户名不存在');
     }

}
  }
public function  index()
    {


      $data = db('b')->order('zan desc')->limit(10)->select();
//        $data = db('dian')->field('bookid')->select();
     
     $pun = db('b')->order('plun desc')->limit(10)->select();
 $ds = db('b')->where('type','都市')->order('zan desc')->limit(5)->select();
$xh = db('b')->where('type','玄幻')->order('zan desc')->limit(5)->select();
$wx = db('b')->where('type','武侠')->order('zan desc')->limit(5)->select();
$mz = db('b')->where('type','名著')->order('zan desc')->limit(5)->select();
$ls = db('b')->where('type','历史')->order('zan desc')->limit(5)->select();

$this->assign('xh',$xh);
$this->assign('ds',$ds);
$this->assign('wx',$wx);
$this->assign('mz',$mz);
$this->assign('ls',$ls);

     $this->assign('pun',$pun);
$this->assign('data',$data);
        return $this->fetch();
        session('uid',uid);


    }
 public function delete()
    {
        session(null);
       $this->success('退出成功','Index/index');
    }
    public function data()
    {
          return $this->fetch(); 
    }
     public function update()
    {
      $content=input('post.');
      // dump($content);
       $val = new IndexValidate();
        if(!$val->check($content))
        {
          $this->error($val->getError());
          exit;
        }
         $yh =new Yh();
     $result = $yh->where('name',$content['name'])->find();
     // dump($result);
     if($result){
      $id=$result['yhid'];
      // dump($id);
      // dump($result['password']);
 if($result['password'] === md5($content['md5']))
      {
        $password=md5($content['password']);
      
$ret=db('yh')->where('yhid',$id)->update(['password' => $password]);
if($ret){
   session(null);

   $this->success('修改成功','index/Index/index');
   
}else{
 $this->error('修改失败,可能是前后密码相同');
}
     }
     

         
    }
    else{
      $this->error('用户名不存在');
     }
   
}
}