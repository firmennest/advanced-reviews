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

  $postNumber = intVal($attr['anzahl']);
  $postOffset = intVal($attr['offset']);
  $postSet = intVal($attr['grid']);

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
    <div class="uk-text-center">
      <ul class="uk-child-width-1-1@s uk-child-width-1-<?php echo $postSet; ?>@m" uk-grid uk-height-match="target: .fn-adv-rev-content">
        <?php while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
          $fnAdvReview = new fnAdvReview;
          $fnAdvReviewMeta = $fnAdvReview->getMeta(get_the_ID());
          ?><li>
            <div class="uk-card uk-card-small">
              <div class="uk-card-header"><?php
                echo $fnAdvReview->getStars($fnAdvReviewMeta['value']);
              ?></div>
              <div class="uk-card-body">
                <div class="fn-adv-rev-content">
                  <?php if(!empty($fnAdvReviewMeta['title'])){
                    ?><div class="fn-adv-rev-title uk-h3"><?php echo $fnAdvReviewMeta['title']; ?></div><?php
                  }
                  the_content(); ?>
                </div>
                <div class="fn-adv-rev-details">
                  <span class="fn-adv-rev-name uk-h4 uk-margin-remove"><?php the_title(); ?></span>
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
