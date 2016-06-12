<?php
/**
 * Created by PhpStorm.
 * User: longyu
 * Date: 2016/6/12
 * Time: 13:16
 */
header("Content-type: text/html; charset=utf-8");
include "PHPImage/PHPImage.php";

$phpImage=new PHPImage();
$result=$phpImage->WaterMarkText("D:\\ysj\\wamp\\www\\phputil\\Images\\1.jpg","longyu",540,300,2,"D:\\ysj\\wamp\\www\\phputil\\Images\\");
echo $result["message"];