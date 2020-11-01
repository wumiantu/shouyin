<?php
	class UploadOauth {//类定义开始
		private $config =   array(
			'maxSize'           =>  -1,    // 上传文件的最大值
			'allowExts'         =>  array(),    // 允许上传的文件后缀 留空不作后缀检查
			'savePath'          =>  '',// 上传文件保存路径
			'saveRule'          =>  'uniqid',// 上传文件命名规则
		);

		// 错误信息
		private $error = '';
		
		// 上传成功的文件信息
		private $uploadFileInfo ;

		public function __get($name){
			if(isset($this->config[$name])) {
				return $this->config[$name];
			}
			return null;
		}

		public function __set($name,$value){
			if(isset($this->config[$name])) {
				$this->config[$name]    =   $value;
			}
		}

		public function __isset($name){
			return isset($this->config[$name]);
		}
		
		/**
		 * 架构函数
		 * @access public
		 * @param array $config  上传参数
		 */
		public function __construct($config=array()) {
			if(is_array($config)) {
				$this->config   =   array_merge($this->config,$config);
			}
		}
		public function Local(){
			$rule = $this->saveRule;
			if(function_exists($rule)) {
				$pathName = $rule();
			}else{
				$pathName = $this->saveRule;
			}
			$this->savePath = rtrim($this->savePath,'/').'/'.$pathName;
			unset($this->config['saveRule']);
			dump($this->config);
		}
	}
?>