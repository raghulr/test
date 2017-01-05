<?php
include "../private/include.php";
if(isset($_GET['width'])){
	$width = $_GET['width'];
	$height = ((($width/16)*9)*0.768);
	$height = round($height);
}else{
	$width=1000;
	$height=432;
}
$film = get_film_by_id(7);

$headers = array('h1' => "BBC",
								 'h2' => "Gene Hunt Destroys the Blue Peter Garden",
								 'h2' => "Ashes to Ashes, Series 3 Episode 4 Preview",
								 'h3' => "Moogi Data Integration Demo",
								 'h5' => "<a href='http://www.youtube.com/watch?v=SWKgSDaBsxE&feature=em-share_video_user'>video source (YouTube)</a>");

if($_GET['v'] == 2) {
	$swf_file = 'player_dynamicResize.swf';
	//$height = '1000';

 } else {
	$swf_file = 'player_dynamicResize.swf';
	//$height = '432';
 }

 
$tpl = new Template();
$tpl->assign('title', "video2");
$tpl->assign('headers', $headers);
$dev_type_suport = 'yes';
//echo $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/iPhone|iPod|iPad|BlackBerry|Android|X11/', $_SERVER['HTTP_USER_AGENT']))  
    $dev_type_suport = "not";

$tpl->assign('device_type',$dev_type_suport);

$tpl->assign('player_type', 'youtube');
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$tpl->assign('pageUrl',$url);
$tpl->assign('player_id', 'SWKgSDaBsxE');
$tpl->assign('film', $film);
$tpl->assign('swf_file', $swf_file);
$tpl->assign('height', $height);
$tpl->assign('width', $width);
$tpl->display('player_dynamic.tpl');
?>