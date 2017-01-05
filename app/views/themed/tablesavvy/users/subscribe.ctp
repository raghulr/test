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
    <?php echo $this->element('sign_up', array('reservation'=>TRUE));?>
  </div>
</div>
<script>
    var storageFlag = 0;
    $(window).on('load',function(){
        var mc = '<?php echo $mc; ?>';
        if(typeof(Storage) !== "undefined"){
            storageFlag = localStorage.flag;
            if(mc != "success"){
                storageFlag = 0;
            }
        }
    });

    $(window).on('unload',function(){
        if(typeof(Storage) !== "undefined"){
           localStorage.flag = storageFlag;
        }
    });
    
</script>