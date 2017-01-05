<style>
    input {
        margin: 1px;
        width: 74px;
    }
    .checkbox {
        float: left;
        margin: 18px 0 0 40px;
        width: 410px;
    }
    #rest_no {
        border-right: 2px ridge #FFFFFF;
        float: left;
        height: 100%;
        width: 200px;
    }
    #rest_no_user1 {
        border-right: 2px ridge #FFFFFF;
        float: left;
        height: 100%;
        width: 100px;
    }
    #rest_no_user4 {
        float: left;
        height: 100%;
        width: 75px;
    }
    #rest_no_user {
        border-right: 2px ridge #FFFFFF;
        float: left;
        height: 100%;
        width: 256px;
    }
    #rest_no_user2 {
        border-right: 2px ridge #FFFFFF;
        float: left;
        height: 100%;
        width: 104px;
    }
    #rest_no_user3 {
        border-right: 2px ridge #FFFFFF;
        float: left;
        height: 100%;
        width: 98px;
    }
    .sear_rest {
        float: left;
        height: 22px;
        margin: 0px 0 5px 18px;
        width: 145px;
    }
    .submit{
        float: left;
        margin: 0px 0 5px 8px;
    }
    .container_cont .navi_content {
        min-height: 648px;
    }
    .checkbox {
        width: 372px;
    }
    .user_credit {
        float:left;
        height:16px;
        margin:12px 0px 5px 18px;
        width:40px;
    }
    .user_head{
        width: 100%;
        float: left
    }
    .user_left{
        width: 34%;
        float: left
    }
    .user_right{
        width: 65%;
        float: right;
        padding-top: 0px;
    }
    .user_right label{
        float: left;
        width: 50%;
        font-size: 14px;
    }
</style>
<div id="credit_message"></div>
<div id="changedate">
    <?php
    if (isset($this->params['named']['page']) && !empty($this->params['named']['page']))
        $page = 'page:' . $this->params['named']['page'];
    else
        $page = 1;
    ?>
    <div class="cont_navi">
        <ul class="navigation">
            <li><?php echo $html->link('Dashboard ', array('controller' => 'users', 'action' => 'dashboard')) ?></li>
            <li ><?php echo $html->link('Count', array('controller' => 'Restaurants', 'action' => 'count')); ?></li>
            <li ><?php echo $html->link('Restaurants', array('controller' => 'Restaurants', 'action' => 'index'), array('class' => 'active')); ?></li>
            <li class="active_link"><?php echo $html->link('Users', array('controller' => 'users', 'action' => 'index', 'delete')); ?></li>
            <li><?php echo $html->link('Statistics', array('controller' => 'users', 'action' => 'statistics')); ?></li>
            <li><?php echo $html->link('Neighborhoods', array('controller' => 'neighborhoods', 'action' => 'index')); ?></li>
            <li><?php echo $html->link('Cuisines', array('controller' => 'cuisines', 'action' => 'index')); ?></li>
            <li><?php echo $html->link('Table', array('controller' => 'Restaurants', 'action' => 'addtable')); ?></li>
        </ul>
    </div>

    <div class="navi_content" id="change">
        <div class="res_tabl">
            <div class="user_head">
                <div class="user_left">
                    <span class="Uers_pro" style="width: 100%"><h1>Manage Report</h1></span> 
                </div>
            </div>
            <style>
                .report th{background: #3B3B3B;color:#FFF;padding: 10px 0;}
                .report td{padding: 10px 5px; border-bottom: 1px solid #CCC;}
            </style>
            <table cellpadding="5" cellSpacing="5" width="100%" border="0" class="report" >
                <tr>
                    <th  width="15%">Key</th>
                    <th width="20%">Query Cache</th>
                    <th width="15%">Tables</th>
                    <th width="15%">Connections</th>
                    <th width="10%">Threads</th>
                    <th width="15%">InnoDB Buffer Pool</th>
                    <th width="10%">Date added</th>
                </tr>
                <?php
                if (!empty($reports)):
                    $i=0;
                    foreach ($reports as $key => $report):
                        $classes = 'style="background:#CACACA"';
                        if ($i % 2)
                            $classes = 'style="background:#E8E7E7"';
                        $i++;
                        $content = $report['Report']['mysqlreport_content'];
                        $date = date('Y-m-d H:i:s',strtotime($report['Report']['created_at']));
                        ?>    
                        <tr <?php echo $classes;?>>
                            <td><?php echo $part1 = trim(GetBetween('__ Key _________________________________________________________________', '%Used:', $content)); ?></td>	
                            <td><?php echo $part2 = trim(GetBetween('__ Query Cache _________________________________________________________', '%Used:', $content)); ?></td>	
                            <td><?php echo $part3 = trim(GetBetween('__ Tables ______________________________________________________________', '%Cache:', $content)); ?></td>	
                            <td><?php echo $part4 = trim(GetBetween('__ Connections _________________________________________________________', '%Max:', $content)); ?></td>	
                            <td><?php echo $part5 = trim(GetBetween('__ Threads _____________________________________________________________', '%Hit:', $content)); ?></td>	
                            <td><?php echo $part6 = trim(GetBetween('__ InnoDB Buffer Pool __________________________________________________', '%Used:', $content)); ?></td>	
                            <td><?php echo $date; ?></td>
                        </tr>
                    <?php endforeach; ?>                
                <?php endif; ?>  
            </table>
        </div> 
    </div>
    <div class="navi_botom"></div>
</div>
<?php

function GetBetween($var1, $var2, $pool) {
    $temp1 = strpos($pool, $var1) + strlen($var1);
    $result = substr($pool, $temp1, strlen($pool));
    $dd = strpos($result, $var2);
    if ($dd == 0) {
        $dd = strlen($result);
    }

    return substr($result, 0, $dd);
}
?>