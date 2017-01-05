<style>
    @import("/theme/tablesavvy/css/reset.css");
  
  * {
    box-sizing: border-box;
  }
    
  body {
    padding:0px !important;
    width: 300px;
    height: 390px;
    position: relative;
    margin: 0;
    font-family: Helvetica,Arial,sans-serif;
    font-size: 8.5pt;
  }
  
  .header {
    position: absolute;
    left: 0; right: 0;
    z-index: 2;
    /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+100&1+0,0+100 */
    background: -moz-linear-gradient(top, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,1)), color-stop(100%,rgba(0,0,0,0))); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(0,0,0,0) 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(0,0,0,0) 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, rgba(0,0,0,1) 0%,rgba(0,0,0,0) 100%); /* IE10+ */
    background: linear-gradient(to bottom, rgba(0,0,0,1) 0%,rgba(0,0,0,0) 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#00000000',GradientType=0 ); /* IE6-9 */
  }

  h1#logo {
    background: url('/theme/tablesavvy/img/tablesavvy_brand_logo.png') no-repeat center;
    background-size: 110px auto;
    height: 90px;
    margin: 0 auto 0;
    text-indent: -999em;
  }

.tag {
  position: relative;
/*   0: 129px; */
  font-size: 21px;
  text-align: center;
  padding: 0 20px;
  z-index: 1;
  font-weight: 100;
  color: #fff;
  text-shadow: 0 1px 2px rgba(0,0,0,.8);
}

@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) { 
  h1#logo { background-image: url('/theme/tablesavvy/img/tablesavvy_brand_logo@2x.png'); }
}
  
  .featured {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
  }
  
  .tsSubmit a {
    background: #4CBD7D;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    height: 60px;
    line-height: 60px;
    text-decoration: none;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    font-weight: 300;
    font-size: 16px;
  }
  .tsSubmit a:hover {
    background-color: #4ad385;
  }
  .product .bg {
    opacity: 0.8;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 60px;
    background-position: center;
    background-size: cover;
  }

  h3 {
      color: #000000;
      font-family: Georgia,"Times New Roman",Times,serif;
      font-size: 16pt;
      line-height: 1.1em;
      margin-bottom: 0.5em;
      margin-top: 0.5em;
      text-align: center;
  }

  #change{
      width: 100%;
  }    
  .jcarousel-prev-disabled{
      background:url(images/left_dis.png) no-repeat 0 0 transparent !important;
      height:15px !important;
  }
  .jcarousel-next-disabled{
      background:url(images/right_dis.png) no-repeat 0 0 transparent !important;
      height:15px !important;
  }
  .toolTip{
      display:inline !important;
  }
  .jcarousel1-skin-tangos .jcarousel1-clip-horizontal{
      margin:0 0 0 0px !important;
      width: 300px !important;
      height: 390px !important;
  }
  #select_search{
      padding-bottom:0px !important;
  }
  .clearfix{
      overflow:inherit !important;
  }
  .jcarousel-skin-tango .jcarousel-container-horizontal{
      width:150px;
  }
  a{
      color:#FFFFFF !important;
      font-weight:bold;
  }
  .search{
      text-decoration:none; 
      color:#FFFFFF; 
      text-shadow:0 1px 0 #444444; 
  }
  .product .prodcut_details {
    position: absolute;
    bottom: 74px;
    left: 0;
    right: 0;
    width: 100%;
    text-align: center;
    padding: 0 20px; 
    z-index: 1;
  }
  .product .prodcut_details {
      color: #666666;
      font-size: 0.8em;
      margin-bottom: 5px;
  }
  .res_name {
      text-align: center;
      font-size: 18px;
      font-weight: bold;
      text-decoration: none;
      letter-spacing: 0.1em;
  }
  .product-name h2{
  	font-size:16px;
  	display:block;
  	font-weight:bold;
  	color: #FFF;
    margin-bottom: 10px;
  }
  .product-name h3{
    font-family: georgia, "Times New Roman", serif;
    font-size: 13px;
    font-style: italic;
    font-weight: normal;
    letter-spacing: normal;
    color: #fff;
  }
  .product-name a:hover h3 { 
    text-decoration: underline; 
  }
  .prodcucontainer li.product span {
      color: #797A7A;
      font-family: arial;
      font-size: 14px !important;
      padding-bottom: 4px;
      z-index: 2;
  }
  .prodcut_details{
      float: left;
     width: 100%;
  }
  
  .chnge{
  	color:#FFFFFF !important;
  }
  
  .prodcucontainer ul{
      margin: 0;
      padding: 0;
  }
  .prodcucontainer li.product {
      float: left;
      list-style: none outside none;
      margin: 0;
      width: 300px;
      height: 390px;
      color: #FFF;
      position: relative;
      background: #020202;
  }
  #mycarousel li{
    list-style: none;
    float: left;
    width: 100%;
  }

<?php
    if (count($restaurant_detail) == 0) {
        echo "#tsWidget img {float: left;max-height: 308px;margin:27px 20px 30px 0px;max-width: 300px;padding: 2px 0;border: 0 none !important;}";
    }
?>
</style>
<?php $restaurant_url1 = $html->url(array('controller'=>'homes','action'=>'index','&utm_source=chicagomag&utm_medium=widgets&utm_campaign=TableSavvyWidgets'),true); ?>
<div id="wrapper" style="border-style:none !important;">
    <div id="tsWidget" class="module-hatched clearfix" style="border-style:none !important;" >
        <div onclick='open_in_new_tab("<?php echo $restaurant_url1;?>")'>
        <?php
        if (count($restaurant_detail) == 0) {
            $avail_url = $html->url(array('controller' => 'homes', 'action' => 'index'), true);
            $image_url = $html->url('/images/NoAvailablity3.jpg', true);
            $image = $html->image($image_url, array('align' => 'center'));
            echo $html->link($image, $avail_url, array('escape' => false, 'target' => '_blank'));
        } else {

            ?>
        </div>
        <div class="header" onclick="open_in_new_tab('https://www.tablesavvy.com?&utm_source=chicagomag&utm_medium=widgets&utm_campaign=TableSavvyWidgets')">
          <h1 id="logo">TableSavvy</h1>
          <p class="tag">Last Minute Reservations With Exclusive Perks</p>
        </div>
        <div class="featured clearfix">
            <div class="prodcucontainer" id="select_search">
                <ul id="mycarousel1 rest_product" class="jcarousel1-skin-tangos">
                    <?php 
                    App::import('model','Neighborhood');
                    $neighborhood = new Neighborhood;
                    $j = 1;
                    foreach($restaurant_detail as $restaurants){ 
                        $id = $restaurants['Restaurant']['id'];  
                        $full_res_name= str_replace("'", "", $restaurants['Restaurant']['name']);
                        
                        // Featured image at top of page
                        $image = $slideshow->find('all', array(
                          'conditions' => array(
                            'restaurant_id' => $id,
                            'order_list' => 1
                          ),
                          'fields' => array(
                            'path',
                            'description'
                          )
                        ));
                        $image = $image[0]['Slideshow']['path'];
                    ?>
                    <li id="prodcucontainer_<?php echo $id;?>" class="product <?php if(($j%3)==0) echo 'last';?>">                 
                      <?php
                          $url = $html->url(array('controller'=>'homes', 'action'=>'details',$restaurants['Restaurant']['slug_name'].'?theme=tablesavvy&utm_source=chicagomag&utm_medium=widgets&utm_campaign=TableSavvyWidgets'),true);
                          //echo $html->link($image,$url,array("escape"=>false,"target"=>"_blank","class"=>"restuarant_image","rel"=>$id,"onclick"=>"_gaq.push(['_trackEvent', 'Outside links', 'Chicagomag widget','".$full_res_name."']);"));
                      ?>
                        <div class="prodcut_details">
                            <?php $restaurant_name = strtoupper($restaurants['Restaurant']['name']);?>
                            <span class="product-name" title="<?php echo $restaurant_name;?>">
                                <a target="_blank" href="<?php echo $url;?>" class="res_name" rel="<?php echo $id;?>" onclick="_gaq.push(['_trackEvent', 'Outside links', 'Chicagomag widget','<?php echo $full_res_name;?>']);">
                                    <h2>
                                    <?php 
                                    if(strlen($restaurants['Restaurant']['name'])>38)
                                        echo substr($restaurant_name,0,36).'...';
                                    else
                                        echo $restaurant_name;
                                    ?>
                                    </h2>
                                    <h3>
                                      Book Tonight
                                    </h3>
                                </a>
                            </span>    
                        </div>
                        <div class="bg" style="background-image: url('/img/small/<?php echo $image ?>');"></div>
                    </li>
                    <?php $j++; } ?>           
                </ul>
            </div>
        </div>
        <div class="tsSubmit">
          <?php $search_url=$html->url('/homes?theme=tablesavvy&utm_source=chicagomag&utm_medium=widgets&utm_campaign=TableSavvyWidgets',true);?>
          <a href="<?php echo $search_url;?>" target="_blank" class="searchs" onclick="_gaq.push(['_trackEvent', 'Outside links', 'Chicagomag widget','Search available restaurants']);">Find A Table Tonight</a>
        </div>
         <?php } ?>
    </div>
</div>
<script>
function open_in_new_tab(url)
{
  var win=window.open(url, '_blank');
  win.focus();
}

// Set pixelRatio to 1 if the browser doesn't offer it up.
        var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
         
        // Rather than waiting for document ready, where the images
        // have already loaded, we'll jump in as soon as possible.
        $(document).ready(function() {
            if (pixelRatio > 1) {
                $('.bg').each(function() {
                    var tmp = $(this).attr('style');
                    tmp = tmp.replace(".jpg","@2x.jpg");
                    tmp = tmp.replace(".JPG","@2x.JPG");
                    tmp = tmp.replace(".png","@2x.png");
                    tmp = tmp.replace(".PNG","@2x.PNG");
                    // Very naive replacement that assumes no dots in file names.
                    $(this).attr('style', tmp);
                });
            }
        });
</script>