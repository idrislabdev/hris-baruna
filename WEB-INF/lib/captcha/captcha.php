<?
 $data = base64_decode($_REQUEST['dt']);
 $im = imagecreate(65,20);
 $white = imagecolorallocate($im,255,255,255);
 $gray = imagecolorallocate($im, 210,210,210);
 $black = imagecolorallocate($im, 0,0,0);
 imagestring($im,4,8,2,$data,$black);
 imageline($im,0,10,65,10,$gray);
 imagepng($im);
?>

