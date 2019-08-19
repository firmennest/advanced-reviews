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
              $fnAdvReviewMeta = $fnAdvReview->getMeta(get_the_ID());
              ?><li>
                <div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
                  <div class="uk-width-1-3">
                    <?php
                    if ($settingsGeneral['placeholderImageStatus'] === 'on'){
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
                    }
                    ?>
                  </div>
                  <div class="uk-width-2-3">
                    <div class="fn-adv-rev-content uk-flex">
                      <div class="uk-width-1-1">
                        <?php if(!empty($fnAdvReviewMeta['title'])){
                          ?><div class="fn-adv-rev-title uk-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
                        }
                        the_content(); ?>
                      </div>
                    </div>
                    <div class="fn-adv-rev-details">
                      <div class="uk-flex uk-flex-middle uk-grid-small" uk-grid>
                        <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                        <?php
                        $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
                        if($fields){
                          foreach ($fields as $key => $field) {
                            foreach ($field as $value) {
                              if (!empty($value['label'])) {
                                ?><span class="fn-adv-rev-field-<?php echo sanitize_title($value['label']); ?>"><?php echo $value['label']; ?></span><?php
                              }
                            }
                          }
                        }
                        ?>
                      </div>
                    </div>
                    <?php
                    echo $fnAdvReview->getStars($fnAdvReviewMeta['value']);
                    ?>
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
  }else{
    $advRev_query = new WP_Query( $args ); ?>
    <?php if ( $advRev_query->have_posts() ) :
      ?><div class="uk-position-relative uk-text-center fn-adv-rev-frame" uk-height-match="target: .fn-adv-rev-content">
        <div uk-slider>
          <ul class="uk-slider-items uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m">
            <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
              $fnAdvReview = new fnAdvReview;
              $fnAdvReviewMeta = $fnAdvReview->getMeta(get_the_ID());
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
                  <div class="uk-flex uk-flex-center uk-flex-middle uk-grid-small" uk-grid>
                    <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                    <?php
                    $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
                    if($fields){
                      foreach ($fields as $key => $field) {
                        foreach ($field as $value) {
                          if (!empty($value['label'])) {
                            ?><span class="fn-adv-rev-field-<?php echo sanitize_title($value['label']); ?>"><?php echo $value['label']; ?></span><?php
                          }
                        }
                      }
                    }
                    ?>
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
