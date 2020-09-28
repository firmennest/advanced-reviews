<?php

defined( 'ABSPATH' ) || exit;

?><div class="uk-card uk-card-small">
  <div class="uk-card-header"><?php
  if (isset($settingsGeneral['placeholderImageStatus']) && $settingsGeneral['placeholderImageStatus'] === 'on'){
    $image_id = intVal($settingsGeneral['placeholderImage']);
    if(has_post_thumbnail()){
      ?><div class="fn-adv-rev-image uk-margin-bottom">
        <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="">
      </div><?php
    }else if($image_id > 0){
      ?><div class="fn-adv-rev-image uk-margin-bottom">
        <img src="<?php echo wp_get_attachment_image_src( $image_id, 'medium' )[0]; ?>" alt="">
      </div><?php
    }
  }
  if(is_float($fnAdvReviewRating)){
    echo $fnAdvReview->getStars($fnAdvReviewRating);
  }
  ?></div>
  <div class="uk-card-body">
    <div class="fn-adv-rev-content">
      <?php if(!empty($fnAdvReviewMeta['title'])){
        ?><div class="fn-adv-rev-title uk-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
      }
      echo fn_adv_rev_fields_pos('topText');
      ?><div class="fn-adv-rev-message uk-margin-large-left uk-margin-large-right uk-padding-small"><?php the_content(); ?></div><?php
      echo fn_adv_rev_fields_pos('bottomText');
    ?></div>
    <div class="fn-adv-rev-details">
      <?php echo fn_adv_rev_fields_pos('topName'); ?>
      <div class="uk-flex uk-flex-middle uk-flex-center uk-grid-small fn-adv-rev-name-frame" uk-grid>
        <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
        <?php echo fn_adv_rev_fields_pos('nextToName'); ?>
      </div>
      <?php echo fn_adv_rev_fields_pos('bottomName'); ?>
    </div>
  </div>
</div>
