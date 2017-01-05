<style>
.already_reserved{
    height: 300px;
    margin:46px 20px 0 38px;
}
.already_reserved h2 {
    font-size: 20px;
    font-weight: normal;
    color: #000000;
    font-family: Georgia,"Times New Roman",Times,serif;
    font-size: 18pt;
    font-weight: normal;
    line-height: 1.3em;
    margin-bottom: 0.5em;
    margin-top: 0.5em;
} 
</style>
<div class="ui container body already_reserved">
    <p><?php echo 'Sorry, but this table is unavailable! </br> Please check back our site at  '.$html->link('www.tablesavvy.com',$html->url(array('controller' => 'homes', 'action' => 'index', 'admin' => false),true)).' to see what other restaurants have availabilty.' ?></p>
</div>