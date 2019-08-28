<?php

defined( 'ABSPATH' ) || exit;

function fn_adv_rev_fields_pos($fieldsMeta,$pos){
  $fields = get_option('fn_adv_rev_setting[fields]');
  if($fieldsMeta){
    $extractedFields = array();
    foreach ($fieldsMeta as $key => $field) {
      foreach ($field as $key => $value) {
        if($fields[$key]['position'] === $pos){
          array_push($extractedFields,$value);
        }
      }
    }
    if(is_array($extractedFields) && count($extractedFields) > 0){
      if($pos === 'top' || $pos === 'bottom'){
        ?><div class="fn-adv-rev-field-<?php echo $pos; ?> uk-display-inline-block"><?php
      }
      foreach ($extractedFields as $value) {
        if (!empty($value['label'])) {
          ?><span class="fn-adv-rev-field-<?php echo sanitize_title($value['label']); ?> uk-text-meta"><?php echo $value['value']; ?></span><?php
        }
      }
      if($pos === 'top' || $pos === 'bottom'){
        ?></div><?php
      }
    }
  }
}

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
    ),
    $attr,
    'advanced-reviews-slider'
  );

  $postNumber = intVal($attr['anzahl']);
  $postOffset = intVal($attr['offset']);
  $postSet = intVal($attr['set']);

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
  if($attr['style'] === 'left'){
    $advRev_query = new WP_Query( $args ); ?>
    <?php if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative fn-adv-rev-frame" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
              $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
              ?><li>
                <div class="uk-flex uk-flex-middle uk-grid-small uk-margin-large-left uk-margin-large-right" uk-grid><?php
                  if ($settingsGeneral['placeholderImageStatus'] === 'on'){
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
                        echo fn_adv_rev_fields_pos($fields,'top');
                        ?><div class="fn-adv-rev-message"><?php the_content(); ?></div><?php
                        echo fn_adv_rev_fields_pos($fields,'bottom');
                      ?></div>
                    </div>
                    <div class="fn-adv-rev-details">
                      <div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
                        <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                        <?php echo fn_adv_rev_fields_pos($fields,'nextTo'); ?>
                      </div>
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
              $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');

              ?><li><?php
                if ($settingsGeneral['placeholderImageStatus'] === 'on'){
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
                    echo fn_adv_rev_fields_pos($fields,'top');
                    ?><div class="fn-adv-rev-message uk-margin-large-left uk-margin-large-right uk-padding-small"><?php the_content(); ?></div><?php
                    echo fn_adv_rev_fields_pos($fields,'bottom');
                  ?></div>
                </div>
                <div class="fn-adv-rev-details">
                  <div class="uk-flex uk-flex-center uk-flex-middle uk-grid-small" uk-grid>
                    <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                    <?php echo fn_adv_rev_fields_pos($fields,'nextTo'); ?>
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
