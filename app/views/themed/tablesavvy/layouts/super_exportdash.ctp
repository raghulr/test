<?php
//header('Expires: 0');
//header ("Last-Modified: " . gmdate("D,d M Y") . " GMT");
//header ("Cache-Control: no-cache, must-revalidate");
//header ("Pragma: no-cache");
//header ("Content-type: application/vnd.ms-excel");
//header ("Content-Disposition: attachment; filename=\"Dashboard_Report" . gmdate("d_M_Y") . ".xls" );
//header ("Content-Description: Generated Report" );
?>
<?php
$file = "Dashboard_Report" . gmdate("d_M_Y") . ".xls";
header ("Last-Modified: " . gmdate("D,d M Y") . " GMT");
header ("Content-type: application/vnd.ms-excel");
header("content-Disposition: attachment; filename=".$file);
header ("Content-Description: Generated Report" );
header('Pragma: no-cache');
header('Expires: 0');
readfile($file);
?>
<?php echo $content_for_layout ?> 