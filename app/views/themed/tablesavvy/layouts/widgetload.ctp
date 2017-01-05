<?php
/* SVN FILE: $Id: admin.ctp 17695 2010-08-05 12:30:01Z siva_063at09 $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.skel.views.layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @version       $Revision: 7805 $
 * @modifiedby    $LastChangedBy: AD7six $
 * @lastmodified  $Date: 2008-10-30 23:00:26 +0530 (Thu, 30 Oct 2008) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(), "\n";?>
	<title><?php echo Configure::read('website.name');?> | <?php echo $title_for_layout; ?></title>
	<?php
		//echo $html->meta('icon'), "\n";
		echo $html->meta('keywords', $meta_for_layout['keywords']), "\n";
		echo $html->meta('description', $meta_for_layout['description']), "\n";
		require_once('_widgetload_head.ctp');
		echo $asset->scripts_for_layout();
	?>
     		<script type="text/javascript">
$(function () {
    	Date.firstDayOfWeek = 0;
	Date.format = 'yyyy-mm-dd';
        $('.date-pick').datePicker(
		{
			startDate:'2013-08-02',
			endDate: (new Date()).asString()
		}
	);
	$('.date-pick').datePicker();
        $('#container').highcharts({
            chart: {
                type: 'line',
                marginBottom: 50,
                width:800
            },
            title: {
                text: 'Widgets Access Log',
                x: -20 //center
            },
            subtitle: {
                text: 'www.tablesavvy.com/widgets/time_list',
                x: -20
            },
            xAxis: {
                gridLineColor: '#ffffff',
                gridLineWidth: '2px',
//tickmarkPlacement:'on',
                lineColor: '#ffffff',
                labels: {
                    align: 'left',
                    rotation:90},
                categories: ['00.00', '00.30', '01.00','01.30', '02.00', '02.30', '03.00','03.30', '04.00',
                '04.30', '05.00','05.30', '06.00', '06.30', '07.00','07.30', '08.00',
            '08.30', '09.00','09.30', '10.00', '10.30', '11.00','11.30', '12.00','12.30', '13.00','13.30', '14.00',
        '14.30', '15.00','15.30', '16.00','16.30', '17.00','17.30', '18.00','18.30', '19.00','19.30', '20.00','20.30',
    '21.00','21.30','22.00','22.30','23.00','23.30','24.00']
            },
            yAxis: {
                minTickInterval:50,
                min: 0,
                title: {
                    text: 'No of access'
                },
                 plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: 'Times'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: '<?php echo $logdate;?>',
                data: [<?php echo $yeardata;?>]
            }]
        });
    });
    

		</script>
</head>
<body class="admin">
<?php
if ($session->check('Message.error')):
		echo $session->flash('error');
endif;
if ($session->check('Message.success')):
		echo $session->flash('success');
endif;
if ($session->check('Message.flash')):
		echo $session->flash();
endif;
?>
</div>
<div class="header">
	<div class="header_cont">
	<div class="logo"><?php echo $html->image('/images/logo_new.png');?></div>
    <div class="admin_head">
    	<div class="ad_text"><span id="admin_text">Widget Access Report</span></div>
    </div>
    <?php if($this->params['url']['url']=='admin'||$this->params['url']['url']=='users/forget_password'){}else{
?>
    <?php }?>
    </div>
</div>
 <div style="display:none">
      <input type="hidden" id="site_url" value="<?php 
					echo $rest_url = $html->url('/',true);
					?>" />  	 
 </div>
<div class="container">
	<div class="container_cont">
    	
         <?php echo $content_for_layout;?>	
    </div>
</div>
<?php /*?><div class="footer">
	<div class="footer_logo"><?php echo $html->image('footer_logo.png');?></div>
</div><?php */?>
</body>
</html>
