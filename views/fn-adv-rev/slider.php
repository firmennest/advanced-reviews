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
        ?><div class="fn-adv-rev-field-<?php echo $pos; ?> fnadvrev-display-inline-block"><?php
      }
      foreach ($extractedFields as $value) {
        if (!empty($value['label'])) {
          ?><span class="fn-adv-rev-field-<?php echo sanitize_title($value['label']); ?> fnadvrev-text-meta"><?php echo $value['value']; ?></span><?php
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

  $postNumber = (int)$attr['anzahl'];
  $postOffset = (int)$attr['offset'];
  $postSet = (int)$attr['set'];

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
      ?><div class="fnadvrev-position-relative fn-adv-rev-frame" fnadvrev-height-match="target: .fn-adv-rev-content">
        <div fnadvrev-slider>
          <ul class="fnadvrev-slider-items fnadvrev-child-width-1-1@s fnadvrev-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
              $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
              ?><li>
                <div class="fnadvrev-flex fnadvrev-flex-middle fnadvrev-grid-small fnadvrev-margin-large-left fnadvrev-margin-large-right" fnadvrev-grid><?php
                  if ($settingsGeneral['placeholderImageStatus'] === 'on'){
                    ?><div class="fnadvrev-width-1-3"><?php
                    $image_id = (int)$settingsGeneral['placeholderImage'];
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
                  ?><div class="<?php if ($settingsGeneral['placeholderImageStatus'] === 'on'){ ?>fnadvrev-width-2-3<?php }else{ ?>fnadvrev-width-1-1<?php } ?>">
                    <div class="fn-adv-rev-content fnadvrev-flex">
                      <div class="fnadvrev-width-1-1"><?php
                        echo fn_adv_rev_fields_pos($fields,'top');
                        ?><div class="fn-adv-rev-message"><?php the_content(); ?></div><?php
                        echo fn_adv_rev_fields_pos($fields,'bottom');
                      ?></div>
                    </div>
                    <div class="fn-adv-rev-details">
                      <div class="fnadvrev-flex fnadvrev-flex-middle fnadvrev-grid-small" fnadvrev-grid>
                        <span class="fn-adv-rev-name fnadvrev-h4 fnadvrev-margin-remove"><?php the_title(); ?></span>
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
          <ul class="fnadvrev-slider-nav fnadvrev-dotnav fnadvrev-flex-center fnadvrev-margin"></ul>
          <a href="#" class="fnadvrev-position-center-left fnadvrev-slidenav-large" fnadvrev-slidenav-previous fnadvrev-slider-item="previous"></a>
          <a href="#" class="fnadvrev-position-center-right fnadvrev-slidenav-large" fnadvrev-slidenav-next fnadvrev-slider-item="next"></a>
        </div>
      </div>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <?php endif;
  }else{
    $advRev_query = new WP_Query( $args ); ?>
    <?php if ( $advRev_query->have_posts() ) :
      ?><div class="fnadvrev-position-relative fnadvrev-text-center fn-adv-rev-frame" fnadvrev-height-match="target: .fn-adv-rev-content">
        <div fnadvrev-slider>
          <ul class="fnadvrev-slider-items fnadvrev-child-width-1-1@s fnadvrev-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
              $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');

              ?><li><?php
                if ($settingsGeneral['placeholderImageStatus'] === 'on'){
                  $image_id = $settingsGeneral['placeholderImage'];
                  if(has_post_thumbnail()){
                    ?><div class="fn-adv-rev-image fnadvrev-margin-bottom">
                      <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="">
                    </div><?php
                  }else if($image_id > 0){
                    ?><div class="fn-adv-rev-image fnadvrev-margin-bottom">
                      <img src="<?php echo wp_get_attachment_image_src( $image_id, 'medium' )[0]; ?>" alt="">
                    </div><?php
                  }
                }
                if($fnAdvReviewRating){
                  echo $fnAdvReview->getStars($fnAdvReviewRating);
                }
                ?><div class="fn-adv-rev-content fnadvrev-flex">
                  <div class="fnadvrev-width-1-1"><?php
                    echo fn_adv_rev_fields_pos($fields,'top');
                    ?><div class="fn-adv-rev-message fnadvrev-margin-large-left fnadvrev-margin-large-right fnadvrev-padding-small"><?php the_content(); ?></div><?php
                    echo fn_adv_rev_fields_pos($fields,'bottom');
                  ?></div>
                </div>
                <div class="fn-adv-rev-details">
                  <div class="fnadvrev-flex fnadvrev-flex-center fnadvrev-flex-middle fnadvrev-grid-small" fnadvrev-grid>
                    <span class="fn-adv-rev-name fnadvrev-h4 fnadvrev-margin-remove"><?php the_title(); ?></span>
                    <?php echo fn_adv_rev_fields_pos($fields,'nextTo'); ?>
                  </div>
                </div>
              </li><?php
            endwhile; ?>
          </ul>
          <ul class="fnadvrev-slider-nav fnadvrev-dotnav fnadvrev-flex-center fnadvrev-margin"></ul>
          <a href="#" class="fnadvrev-position-center-left fnadvrev-slidenav-large" fnadvrev-slidenav-previous fnadvrev-slider-item="previous"></a>
          <a href="#" class="fnadvrev-position-center-right fnadvrev-slidenav-large" fnadvrev-slidenav-next fnadvrev-slider-item="next"></a>
        </div>
      </div>
    <?php wp_reset_postdata(); ?>
    <?php else : ?>
    <?php endif;
  }

  return ob_get_clean();
}
