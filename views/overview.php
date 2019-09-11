<?php
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
    'advanced-reviews-slider'
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
          $fnAdvReview = new fnAdvReview;
          $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
          $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
          ?><li>
            <div class="uk-card uk-card-small">
              <div class="uk-card-header"><?php
              if($fnAdvReviewRating){
                echo $fnAdvReview->getStars($fnAdvReviewRating);
              }
              ?></div>
              <div class="uk-card-body">
                <div class="fn-adv-rev-content">
                  <?php if(!empty($fnAdvReviewMeta['title'])){
                    ?><div class="fn-adv-rev-title uk-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
                  }
                  echo fn_adv_rev_fields_pos($fields,'topText');
                  ?><div class="fn-adv-rev-message uk-margin-large-left uk-margin-large-right uk-padding-small"><?php the_content(); ?></div><?php
                  echo fn_adv_rev_fields_pos($fields,'bottomText');
                ?></div>
                <div class="fn-adv-rev-details">
                  <?php echo fn_adv_rev_fields_pos($fields,'topName'); ?>
                  <div class="uk-flex uk-flex-middle uk-grid-small fn-adv-rev-name" uk-grid>
                    <span class="uk-h4 uk-margin-remove"><?php the_title(); ?></span>
                    <?php echo fn_adv_rev_fields_pos($fields,'nextToName'); ?>
                  </div>
                  <?php echo fn_adv_rev_fields_pos($fields,'bottomName'); ?>
                </div>
              </div>
            </div>
          </li><?php
        endwhile; ?>
      </ul>
    </div>
  <?php wp_reset_postdata(); ?>
  <?php else : ?>
  <?php endif;

  return ob_get_clean();
}
