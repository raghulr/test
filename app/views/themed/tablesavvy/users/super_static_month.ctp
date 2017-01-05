
<ul id="cur_month">
    <li>
        <?php
        if (!empty($min_date) && !empty($max_date)) {
            $min_month = date('M Y', strtotime($min_date));
            $max_month = date('M Y', strtotime($max_date));
        }
        if ($currentdate == 13)
            $currentdate = 1;
        else if ($currentdate == -1)
            $currentdate = 11;
        $lastmonth = $currentdate - 1;
        $nextmonth = $currentdate + 1;
        $dates = date('d-') . $currentdate . date('-Y');
        $month = date("M Y", strtotime($dates));
        $month1 = $month;
        ?>
        <span class="span1" style="margin-top:8px;">
            <?php
//            if ($lastmonth == 0)
//                $lastmonth = 12;
            if (strtotime($min_month) >= strtotime($month)||$lastmonth==0) {
                echo $this->Html->image("../images/back-arrow.png", array('style' => array('width' => 20, 'height' => 20)));
            }else {
                echo $ajax->link($this->Html->image("../images/back-arrow.png", array('style' => array('width' => 20, 'height' => 20))), "static_month/" . $lastmonth . "", array('escape' => false, 'update' => 'cur_month', 'super' => true));
            }
            ?>
            <!--<a href="javascript:void(0)" id="previous_first_date">
                    <img src="../../images/back-arrow.png" width="25" height="25" />
            </a> -->
        </span>
        <span class="span2" id="cur_date" style="margin-left:20px;">
            <?php
//            if ($lastmonth == 11 || $lastmonth == 10) {
//                $ye = date('-Y');
//                
//                $yea = $ye + 1;
//                $dates = date('d-') . $currentdate . $yea;
//                echo $month = date("M Y", strtotime($dates));
//            }else
            echo $month;
            ?>
        </span>
        <span class="span3">
            <!--  <a href="javascript:void(0)" id="next_first_date">
                      <img src="../../images/forward-arr.png" width="20" height="20" />
              </a> -->
            <?php
            $curmonth = date('m');
            if (empty($currentdate1))
                $currentdate1 = '';
            if ($month > $month1 || $currentdate1 == 2) {
                echo $this->Html->image("../images/forward-arr.png", array('style' => array('width' => 20, 'height' => 20)));
            } elseif ($curmonth >= $nextmonth) {
                ?>
                <div id='for'>
                    <?php
                    echo $ajax->link($this->Html->image("../images/forward-arr.png", array('style' => array('width' => 20, 'height' => 20))), "static_month/" . $nextmonth . "", array('escape' => false, 'update' => 'cur_month', 'super' => true));
                } else {
                    echo $this->Html->image("../images/forward-arr.png", array('style' => array('width' => 20, 'height' => 20)));
                }
                ?>
        </span>
    </li>
    <li style="float:none;" class="month"><p><?php echo $month_count; ?></p></li>
</ul>