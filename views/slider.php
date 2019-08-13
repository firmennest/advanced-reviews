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

  $args = array (
      'post_type' => 'fn-adv-rev',
      'posts_per_page' => $postNumber,
      'post_status' => 'publish',
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'offset' => $postOffset
  );
  $advRev_query = new WP_Query( $args ); ?>
  <?php if ( $advRev_query->have_posts() ) :
    ?><div class="uk-position-relative uk-padding uk-text-center" uk-height-match="target: .fn-adv-rev-content">
      <div uk-slider>
        <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m">
          <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
            $fnAdvReview = new fnAdvReview;
            $fnAdvReviewMeta = $fnAdvReview->getMeta(get_the_ID());
            ?><li><?php
              echo $fnAdvReview->getStars($fnAdvReviewMeta['value']);
              ?><div class="fn-adv-rev-content uk-flex uk-padding">
                <div class="uk-width-1-1">
                  <?php if(!empty($fnAdvReviewMeta['title'])){
                    ?><div class="fn-adv-rev-title uk-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
                  }
                  the_content(); ?>
                </div>
              </div>
              <div class="fn-adv-rev-details">
                <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
              </div>
            </li><?php
          endwhile; ?>
        </ul>
        <ul class="uk-slider-nav uk-dotnav"></ul>
        <a href="#" class="uk-position-center-left uk-slidenav-large" uk-slidenav-previous uk-slider-item="previous"></a>
        <a href="#" class="uk-position-center-right uk-slidenav-large" uk-slidenav-next uk-slider-item="next"></a>
      </div>
    </div>
  <?php wp_reset_postdata(); ?>
  <?php else : ?>
  <?php endif;

  return ob_get_clean();
}
