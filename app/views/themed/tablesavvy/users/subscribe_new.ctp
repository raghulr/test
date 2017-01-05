<div class="ui body container">
  <div class="ui segment">
    <?php if ($mc == 'success') { ?>
      <div class="ui message">
        <p>Congrats! You're on your way to saving 30% on last minute reservations. Sign up below or <a href="/all_restaurant" style="color: #333">browse our restaurants for tonight</a></p>
      </div>
    <?php } else { ?>
      <div class="ui error message">
        <?php echo $mc ?>
      </div>
    <?php } ?>
    <h3>Become a member</h3>
    <p>Already a member? <a href="#" class="signin_trigger">Sign in</a></p>
    <?php echo $this->element('sign_up', array('reservation'=>TRUE,'status'=>$mc,'email' => $email));?>
  </div>
</div>
<script>
    var storageFlag = 0;
    $(document).ready(function(){
        var mc = '<?php echo $mc; ?>';
        storageFlag = localStorage.flag;
        if(mc != "success"){
            storageFlag = 0;
            localStorage.pflag = 1;
        }else{
            localStorage.success = 1;
            $('.cookie.nag.subscriptionList').nag('dismiss');
            $('.desktop').removeClass('wrapperContainer');
        }
    });

    $(window).on('unload',function(){
        localStorage.flag = storageFlag;
        if(localStorage.pflag == 1)
            localStorage.pflag = 0;
    });
    
</script>