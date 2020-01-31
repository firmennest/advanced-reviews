<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('advanced-reviews-slider','fn_adv_rev_slider');
function fn_adv_rev_slider($attr)
{
  ob_start();
  $attr = shortcode_atts(
    array(
      'anzahl' => -1,
      'offset' => 0,
      'set' => 1,
      'style' => 'center',
      'review' => ''
    ),
    $attr,
    'advanced-reviews-slider'
  );

  $postNumber = (int)$attr['anzahl'];
  $postOffset = (int)$attr['offset'];
  $postSet = (int)$attr['set'];

  $postIDs = $attr['review'];
  $postIDs = array_map('intval', explode(',',$postIDs));

  if (!is_numeric($postSet)) {
    $postSet = 1;
  }

  $settingsGeneral = get_option('fn_adv_rev_setting[general]');

  $args = array (
      'post_type' => 'fn-adv-rev',
      'posts_per_page' => $postNumber,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'offset' => $postOffset
  );

  if(is_array($postIDs) && count($postIDs) > 0 && $postIDs[0] != 0){
    $args['post__in'] = $postIDs;
    $args['orderby'] = 'post__in';
  }

  if($attr['style'] === 'left'){
    $advRev_query = new WP_Query( $args ); ?>
    <?php if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative fn-adv-rev-frame fn-adv-rev-frame-slider" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
              $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
              ?><li>
                <div class="uk-flex uk-flex-middle uk-grid-small uk-margin-large-left uk-margin-large-right" uk-grid><?php
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
                  ?><div class="<?php if ($settingsGeneral['placeholderImageStatus'] === 'on'){ ?>uk-width-2-3<?php }else{ ?>uk-width-1-1<?php } ?>">
                    <div class="fn-adv-rev-content uk-flex">
                      <div class="uk-width-1-1"><?php
                        echo fn_adv_rev_fields_pos($fields,'topText');
                        ?><div class="fn-adv-rev-message"><?php the_content(); ?></div><?php
                        echo fn_adv_rev_fields_pos($fields,'bottomText');
                      ?></div>
                    </div>
                    <div class="fn-adv-rev-details">
                      <?php echo fn_adv_rev_fields_pos($fields,'topName'); ?>
                      <div class="uk-flex uk-flex-middle uk-grid-small fn-adv-rev-name-frame" uk-grid>
                        <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                        <?php echo fn_adv_rev_fields_pos($fields,'nextToName'); ?>
                      </div>
                      <?php echo fn_adv_rev_fields_pos($fields,'bottomName'); ?>
                    </div>
                    <?php
                    if($fnAdvReviewRating){
                      echo $fnAdvReview->getStars($fnAdvReviewRating);
                    }
                  ?></div>
                </div>
              </li><?php
            endwhile; ?>
          </ul>
          <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
          <a href="#" class="uk-position-center-left uk-slidenav-large" uk-slidenav-previous uk-slider-item="previous"></a>
          <a href="#" class="uk-position-center-right uk-slidenav-large" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      </div>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <?php endif;
  }else{
    $advRev_query = new WP_Query( $args ); ?>
    <?php if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative uk-text-center fn-adv-rev-frame" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());

              ?><li><?php
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
                if($fnAdvReviewRating){
                  echo $fnAdvReview->getStars($fnAdvReviewRating);
                }
                ?><div class="fn-adv-rev-content uk-flex">
                  <div class="uk-width-1-1"><?php
                    echo fn_adv_rev_fields_pos('top');
                    ?><div class="fn-adv-rev-message uk-padding-small"><?php the_content(); ?></div><?php
                    echo fn_adv_rev_fields_pos('bottom');
                  ?></div>
                </div>
                <div class="fn-adv-rev-details">
                  <div class="uk-flex uk-flex-center uk-flex-middle uk-grid-small" uk-grid>
                    <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                    <?php echo fn_adv_rev_fields_pos('nextTo'); ?>
                  </div>
                </div>
              </li><?php
            endwhile; ?>
          </ul>
          <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
          <a href="#" class="uk-position-center-left uk-slidenav-large" uk-slidenav-previous uk-slider-item="previous"></a>
          <a href="#" class="uk-position-center-right uk-slidenav-large" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      </div>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <?php endif;
  }

  return ob_get_clean();
}
