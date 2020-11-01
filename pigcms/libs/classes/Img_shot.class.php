<?php
	class Img_shot{
		private $filename;  
		private $ext;  
		private $x;  
		private $y;  
		private $x1;  
		private $y1;  
		private $width = 124;  
		private $height = 124;  
		private $jpeg_quality = 90;  
		/** 
		 * 构造器 
		 * 
		 *  
		 */ 
		
		/** 
		 * 初始化截图对象
		 *@param filename 源文件路径全明 
		 *@param width  截图的宽 
		 *@param height  截图的高 
		 *@param x  横坐标1 
		 *@param y  纵坐标1 
		 *@param x1  横坐标1 
		 *@param y1  横坐标2 
		 *  
		 */  
		public function initialize($filename,$x,$y,$x1,$y1,$width=124,$height = 124){
			if(file_exists($filename)){
				$this->filename = $filename;  
				$pathinfo = pathinfo($filename);  
				$this->ext = $pathinfo['extension'];  
			}else{  
				$return['status'] = 0;
				$return['data'] = '文件不存在';
				exit(json_encode($return));
			}  
			$this->x = $x;  
			$this->y = $y;     
			$this->x1 = $x1;
			$this->y1 = $y1;
			$this->width = $width;
			$this->height = $height;
		}  
		/** 
		 * 生成截图 
		 * 根据图片的格式，生成不同的截图 
		 */  
		public function generate_shot()  
		{  
			switch($this->ext)  
			{  
				case 'jpg':  
					return $this->generate_jpg();  
					break;  
				case 'jpeg':  
					return $this->generate_jpg();  
					break;  
				case 'png':  
					return $this->generate_png();  
					break;  
				case 'gif':  
					return $this->generate_gif();  
					break;  
				default:  
					return false;  
			}  
		}  
		/** 
		 * 得到生成的截图的文件名 
		 *  
		 */  
		private function get_shot_name(){
			$pathinfo = pathinfo($this->filename);  
			$filename = md5($uid.'pigcms'.date('YmdHis',time()).mt_rand(111111,999999)).'.'.$this->ext;  
			return $pathinfo['dirname'] . '/' .$filename;  
		}  
		/** 
		 * 生成jpg格式的图片 
		 *  
		 */  
		private function generate_jpg()  
		{
			$shot_name = $this->get_shot_name();  
			$img_r = imagecreatefromjpeg($this->filename);  
			$dst_r = ImageCreateTrueColor($this->width, $this->height);  
			
			$w = ($this->x1) - ($this->x);
			$y = ($this->y1) - ($this->y);
			imagecopyresampled($dst_r,$img_r,0,0,$this->x,$this->y,  
			$this->width,$this->height,$w,$y);  
			imagejpeg($dst_r,$shot_name,$this->jpeg_quality);  
			return $shot_name;  
		}  
		/** 
		 * 生成gif格式的图片 
		 *  
		 */  
		private function generate_gif()  
		{  
			$shot_name = $this->get_shot_name();  
			$img_r = imagecreatefromgif($this->filename);  
			$dst_r = ImageCreateTrueColor($this->width, $this->height);  
			$w = ($this->x1) - ($this->x);
			$y = ($this->y1) - ($this->y);
			imagecopyresampled($dst_r,$img_r,0,0,$this->x,$this->y,  
			$this->width,$this->height,$w,$y);  
			imagegif($dst_r,$shot_name);  
			return $shot_name;  
		}  
		/** 
		 * 生成png格式的图片 
		 *  
		 */  
		private function generate_png()  
		{  
			$shot_name = $this->get_shot_name();  
			$img_r = imagecreatefrompng($this->filename);  
			$dst_r = ImageCreateTrueColor($this->width, $this->height);
			$bg =imagecolorallocate($dst_r, 255, 255, 255);
			imagecolortransparent($dst_r,$bg); 
			imagefill($dst_r,0,0,$bg);
			$w = ($this->x1) - ($this->x);
			$y = ($this->y1) - ($this->y);
			imagecopyresampled($dst_r,$img_r,0,0,$this->x,$this->y,  
			$this->width,$this->height,$w,$y);  
			imagepng($dst_r,$shot_name);  
			return $shot_name;  
		}  
	}
?>