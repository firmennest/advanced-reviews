<?php

defined( 'ABSPATH' ) || exit;


?><div class="uk-flex uk-flex-middle uk-grid-small uk-margin-large-left uk-margin-large-right" uk-grid><?php
  if (isset($settingsGeneral['placeholderImageStatus']) && $settingsGeneral['placeholderImageStatus'] === 'on'){
    ?><div class="uk-width-1-3"><?php
    $image_id = intVal($settingsGeneral['placeholderImage']);
    if(has_post_thumbnail()){
      ?><div class="fn-adv-rev-image">
        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="">
      </div><?php
    }else if($image_id > 0){
      ?><div class="fn-adv-rev-image">
        <img src="<?php echo wp_get_attachment_image_src( $image_id, 'medium' )[0]; ?>" alt="">
      </div><?php
    }
    ?></div><?php
  }
  ?><div class="<?php if (isset($settingsGeneral['placeholderImageStatus']) && $settingsGeneral['placeholderImageStatus'] === 'on'){ ?>uk-width-2-3<?php }else{ ?>uk-width-1-1<?php } ?>">
    <div class="fn-adv-rev-content uk-flex">
      <div class="uk-width-1-1"><?php
        echo fn_adv_rev_fields_pos('topText');
        ?><div class="fn-adv-rev-message"><?php the_content(); ?></div><?php
        echo fn_adv_rev_fields_pos('bottomText');
      ?></div>
    </div>
    <div class="fn-adv-rev-details">
      <?php echo fn_adv_rev_fields_pos('topName'); ?>
      <div class="uk-flex uk-flex-middle uk-grid-small fn-adv-rev-name-frame" uk-grid>
        <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
        <?php echo fn_adv_rev_fields_pos('nextToName'); ?>
      </div>
      <?php echo fn_adv_rev_fields_pos('bottomName'); ?>
    </div>
    <?php
    if(is_float($fnAdvReviewRating)){
      echo $fnAdvReview->getStars($fnAdvReviewRating);
    }
  ?></div>
</div>
