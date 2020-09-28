<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('advanced-reviews-overview','fn_adv_rev_overview');
function fn_adv_rev_overview($attr)
{
  ob_start();

  $attr = shortcode_atts(
    array(
      'anzahl' => -1,
      'offset' => 0,
      'grid' => 1,
      'masonry' => 0,
      'review' => ''
    ),
    $attr,
    'advanced-reviews-overview'
  );

  $postNumber = (int)$attr['anzahl'];
  $postOffset = (int)$attr['offset'];
  $postSet = (int)$attr['grid'];

  $masonry = (bool)$attr['masonry'];

  $postIDs = $attr['review'];
  $postIDs = array_map('intval', explode(',',$postIDs));

  if (!is_numeric($postSet)) {
    $postSet = 1;
  }

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

  $advRev_query = new WP_Query( $args ); ?>
  <?php if ( $advRev_query->have_posts() ) : ?>
    <div class="uk-text-center fn-adv-rev-frame fn-adv-rev-frame-overview">
      <?php if ($masonry){
        ?><ul class="uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m" uk-grid="masonry: true;"><?php
      }else{
        ?><ul class="uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m" uk-grid uk-height-match="target: .fn-adv-rev-content"><?php
      }
      while ( $advRev_query->have_posts() ) : $advRev_query->the_post();

        ?><li><?php fn_adv_rev_get_template('overview'); ?></li><?php
      endwhile;
      ?></ul>
    </div><?php
  wp_reset_postdata();
  else :
  endif;
  return ob_get_clean();
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
    $advRev_query = new WP_Query( $args );
    if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative fn-adv-rev-frame fn-adv-rev-frame-slider" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m"><?php
            while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              ?><li><?php fn_adv_rev_get_template('slider-left'); ?></li><?php
            endwhile;
          ?></ul>
          <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
          <a href="#" class="uk-position-center-left uk-slidenav-large" uk-slidenav-previous uk-slider-item="previous"></a>
          <a href="#" class="uk-position-center-right uk-slidenav-large" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      </div><?php
      wp_reset_postdata();
    endif;
  }else{
    $advRev_query = new WP_Query( $args );
    if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative uk-text-center fn-adv-rev-frame" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m"><?php
            while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              ?><li><?php fn_adv_rev_get_template('slider'); ?></li><?php
            endwhile;
          ?></ul>
          <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
          <a href="#" class="uk-position-center-left uk-slidenav-large" uk-slidenav-previous uk-slider-item="previous"></a>
          <a href="#" class="uk-position-center-right uk-slidenav-large" uk-slidenav-next uk-slider-item="next"></a>
        </div>
      </div><?php
      wp_reset_postdata();
    endif;
  }
  return ob_get_clean();
}
