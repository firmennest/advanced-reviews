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
    ),
    $attr,
    'advanced-reviews-slider'
  );

  $postNumber = (int)$attr['anzahl'];
  $postOffset = (int)$attr['offset'];
  $postSet = (int)$attr['grid'];

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
  <?php if ( $advRev_query->have_posts() ) : ?>
    <div class="fnadvrev-text-center">
      <ul class="fnadvrev-child-width-1-1@s fnadvrev-child-width-1-<?php echo $postSet; ?>@m" fnadvrev-grid fnadvrev-height-match="target: .fn-adv-rev-content">
        <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
          $fnAdvReview = new fnAdvReview;
          $fnAdvReviewRating = $fnAdvReview->getRating(get_the_ID());
          $fields = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
          ?><li>
            <div class="fnadvrev-card fnadvrev-card-small">
              <div class="fnadvrev-card-header"><?php
              if($fnAdvReviewRating){
                echo $fnAdvReview->getStars($fnAdvReviewRating);
              }
              ?></div>
              <div class="fnadvrev-card-body">
                <div class="fn-adv-rev-content">
                  <?php if(!empty($fnAdvReviewMeta['title'])){
                    ?><div class="fn-adv-rev-title fnadvrev-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
                  }
                  echo fn_adv_rev_fields_pos($fields,'top');
                  ?><div class="fn-adv-rev-message fnadvrev-margin-large-left fnadvrev-margin-large-right fnadvrev-padding-small"><?php the_content(); ?></div><?php
                  echo fn_adv_rev_fields_pos($fields,'bottom');
                ?></div>
                <div class="fn-adv-rev-details">
                  <span class="fn-adv-rev-name fnadvrev-h4 fnadvrev-margin-remove"><?php the_title(); ?></span>
                  <?php echo fn_adv_rev_fields_pos($fields,'nextTo'); ?>
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
