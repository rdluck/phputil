<?php

/**
 * Created by PhpStorm.
 * User: longyu
 * Date: 2016/6/12
 * Time: 13:16
 */
class PHPImage
{
    /**
     * @param $imgPath 水印图片路径
     * @param $content 水印文字内容
     * @param $contentX 水印文字起始X坐标
     * @param $contentY 水印文字起始Y坐标
     * @param $output 输出方式:1浏览器(默认)，2:保存到指定目录
     * @param $savePath 保存到指定目录(默认为空)
     */
    public function WaterMarkText($imgPath,$content,$contentX,$contentY,$outputType=1,$savePath=''){
        $fontPath=dirname(__FILE__)."/STXIHEI.TTF";
        $result=array();
        if(empty($imgPath)){
            $result["status"]=false;
            $result["message"]="需要添加水印文字的图片路径不能为空!";
            return $result;
        }

        if(!file_exists($imgPath)){
            $result["status"]=false;
            $result["message"]="需要添加水印文字的图片不存在!";
            return $result;
        }

        if($outputType==2&&empty($savePath)){
            $result["status"]=false;
            $result["message"]="保存图片路径不能为空!";
            return $result;
        }

        if($outputType==2&& !is_dir($savePath) ){
            $result["status"]=false;
            $result["message"]="保存图片目录不存在!";
            return $result;
        }
        try
        {
            $img=getimagesize($imgPath);
            if(empty($img)){
                $result["status"]=false;
                $result["message"]="读取图片信息失败!";
                return $result;
            }
            $imageType=image_type_to_extension($img[2],false);
            $imgFun=$this->createImage($imageType);
            $getImg=$imgFun($imgPath);
            $color=imagecolorallocatealpha($getImg,255,255,255,50);
            $fontSize=30;
            echo $content;
            imagettftext($getImg,$fontSize,0,$contentX,$contentY,$color,$fontPath,$content);
            $output=$this->outputImage($imageType);
            echo $outputType;
            if($outputType==1){
                header('Content-type: image/'.$imageType);
                $output($getImg);
            }else{
                $savePath.=pathinfo($imgPath)["filename"]."water".time().".".$imageType;
                $output($getImg,$savePath);
            }
            $result["status"]=true;
            $result["message"]="success!";
            return $result;
        }catch(Exception $ex){
            $result["status"]=false;
            $result["message"]=$ex->getMessage();
            return $result;
        }
    }

    public function createImage($type){
        return "imagecreatefrom{$type}";
    }

    public function outputImage($type){
        return "image{$type}";
    }
}