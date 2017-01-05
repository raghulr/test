
<section class="main home">
<article>

  <div class="banner">
    <div class="feature full rm_champ">
      <div class="desktop">
        <h2>Last minute tables at Chicago's finest restaurants</h2>
        <h3>Book Now and Save 30% on Your Meal</h3>
        <a class="ui animated button inverted primary" href="#quick_reserve" tabindex="0">
          <div class="visible content">Book Now</div>
          <div class="hidden content">
            <i class="right arrow icon"></i>
          </div>
        </a>
        <a href="#quick_reserve" class="down-arrow"><i class="icon dropdown"></i></a>
      </div>
      <div class="mobile">
        <h2>Last minute tables at Chicago's finest restaurants</h2>
        <h3>Sign up and Save 30% on Your Meal</h3>
        <?php echo $form->create('User', array('action' => 'subscribe', 'type' => 'get', 'class' => 'ui form')); ?>
          <div class="inline field">
            <?php
              echo $this->Form->input('Email', array('placeholder' => 'Email Address', 'label'=>FALSE, 'div'=>FALSE));
              echo $this->Form->submit('GO', array('class' => 'ui button primary', 'div'=>FALSE));
            ?>
          </div>
          <div class="ui error message"></div>
        <?php echo $form->end();?>
        <a href="#quick_reserve" class="down-arrow"><i class="icon dropdown"></i></a>
      </div>
    </div>
    <div class="app-dl">
      <a href="https://itunes.apple.com/us/app/tablesavvy/id845047265?ls=1&mt=8" target="_blank"><i class="icon apple"></i></a>
      <a href="https://play.google.com/store/apps/details?id=com.food.tablesavvy" target="_blank"><i class="icon android"></i></a>
      Download The App
    </div>
  </div>

  <div class="quick_reserve" id="quick_reserve">
    <h2>Reserve your table in 2 minutes</h2>
    <h3>TONIGHT</h3>
    <div class="filter_options">
      <ul class="ui basic clearing segment">
        <?php
          date_default_timezone_set('America/Chicago');
          // current time
          $ct = date('H');
          $i = '5'; // 5:00 PM
          $x = 1;
          while($x <= 6) {
        ?>
          <li>
            <a class="ui fluid button<?php if ($ct>=($i+12)) { ?> disabled<?php } ?>" href="/all_restaurant/?time=<?php echo $i; ?>:00&amp;ampm=PM">
              <?php echo $i; ?>:00 PM
            </a>
          </li>
        <?php
          $x++;
          $i++;
        } ?>
      </ul>
      <p class"view_all">
        Just looking? You can <a href="#"><?php echo $html->link('view all restaurants here. ','/all_restaurant'); ?></a></p>
      </p>
    </div>
    <hr />
    <div class="restaurant_list">
      <div class="grid-padded">
          <h3>Featured Restaurants</h3>
          <p><a href="/all_restaurant/">Browse All Restaurants <i class="icon double angle right"></i></a></p>
	      <?php
    			App::import('model','Neighborhood');
    			$neighborhood = new Neighborhood;
    			$j = 1;
    			//$restaurant_detail = $restaurant_detail; //Get the list of featured restaurants from the homes_controller
        ?>
  			<div class="grid">
          <div class="col col-8">
            <a href="/details/<?php echo $restaurant_detail[0]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/medium/<?php echo $restaurant_detail[0]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[0]['Restaurant']['name']; ?></span>
            </a>
          </div>
          <div class="col col-4">
            <a href="/details/<?php echo $restaurant_detail[1]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $restaurant_detail[1]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[1]['Restaurant']['name']; ?></span>
            </a>
          </div>
        </div>
        <div class="grid">
          <div class="col col-4">
            <a href="/details/<?php echo $restaurant_detail[2]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $restaurant_detail[2]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[2]['Restaurant']['name']; ?></span>
            </a>
          </div>
          <div class="col col-4">
            <a href="/details/<?php echo $restaurant_detail[3]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $restaurant_detail[3]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[3]['Restaurant']['name']; ?></span>
            </a>
          </div>
          <div class="col col-4">
            <a href="/details/<?php echo $restaurant_detail[4]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $restaurant_detail[4]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[4]['Restaurant']['name']; ?></span>
            </a>
          </div>
        </div>
        <div class="grid">
          <div class="col col-4">
            <a href="/details/<?php echo $restaurant_detail[5]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/small/<?php echo $restaurant_detail[5]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[5]['Restaurant']['name']; ?></span>
            </a>
          </div>
          <div class="col col-8">
            <a href="/details/<?php echo $restaurant_detail[6]['Restaurant']['slug_name']; ?>">
              <div class="over" style="background-image: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('/img/medium/<?php echo $restaurant_detail[6]['Slideshow']['path'] ?>')">
              </div>
              <span class="name"><?php echo $restaurant_detail[6]['Restaurant']['name']; ?></span>
            </a>
          </div>
        </div>
        <a href="/all_restaurant" class="ui button inverted basic view_all">View All Restaurants <i class="icon angle right"></i></a>
      </div>
    </div>
  </div>
</article>
</section>
<script>
        // Set pixelRatio to 1 if the browser doesn't offer it up.
        var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
         
        // Rather than waiting for document ready, where the images
        // have already loaded, we'll jump in as soon as possible.
        $(document).ready(function() {
            if (pixelRatio > 1) {
                $('.restaurant_list .col .over').each(function() {
                    var tmp = $(this).attr('style');
                    tmp = tmp.replace(".jpg","@2x.jpg");
                    tmp = tmp.replace(".JPG","@2x.JPG");
                    tmp = tmp.replace(".png","@2x.png");
                    // Very naive replacement that assumes no dots in file names.
                    $(this).attr('style', tmp);
                });
            }
        });
</script>