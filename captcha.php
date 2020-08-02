<?php
session_start();
$image=imagecreatetruecolor(105,20);
$bgcolor=imagecolorallocate($image,rand(190,255),rand(190,255),rand(190,255));
imagefilledrectangle($image,0,0,105,20,$bgcolor);
$dic='ASDFGHJKZXCVBNMQWERTYUP87654322345678qazxswedcvfrtbnhyjmuklp';
$dic_indm=strlen($dic)-1;
$cap_code="";
for($i=0;$i<=3;$i++)
{
	$fontsize=5;
	$rgb_1=intval((rand(0,230)+rand(0,230)+rand(0,230))/3);
	$rgb_2=intval((rand(0,230)+rand(0,230)+rand(0,230))/3);
	$rgb_3=intval((rand(0,230)+rand(0,230)+rand(0,230))/3);
	$fontcolor=imagecolorallocate($image,$rgb_1,$rgb_2,$rgb_3);
	$fontcontent=$dic[rand(0,$dic_indm)];
	imagestring($image,$fontsize,($i*25)+rand(5,10),rand(1,6),$fontcontent,$fontcolor);
	$cap_code.=$fontcontent;
}
$_SESSION['authcode'] = $cap_code;
for ($i=0; $i < 100; $i++) { 
    	$pointcolor = imagecolorallocate($image,rand(20,220),rand(20,220),rand(20,220));
    	imagesetpixel($image, rand(1,104), rand(1,19), $pointcolor);
    }
for ($i=0; $i < 3; $i++) { 
    	$linecolor = imagecolorallocate($image,rand(40,220),rand(40,220),rand(40,220));
    	imageline($image, rand(1,95), rand(1,19),rand(10,104), rand(1,19) ,$linecolor);
    }
header("content-type:image/jpeg");
imagejpeg($image);
imagedestroy($image);

?>
