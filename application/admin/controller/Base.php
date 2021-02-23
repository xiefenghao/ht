<?php
namespace  app\admin\controller;
use think\Controller;

class Base extends Controller
{
	protected function _initialize()
{
	if(!session('userid')){
		$this->error('请先登陆','admin/Index/yh');
	}

		}}