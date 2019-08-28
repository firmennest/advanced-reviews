<?php

add_shortcode('advanced-reviews-snippet','fn_adv_rev_snippet');
function fn_adv_rev_snippet($attr)
{
  ob_start();

  $attr = shortcode_atts(
    array(
      'show' => 0,
    ),
    $attr,
    'fn_adv_rev_snippet'
  );
  $showSnippet = intVal($attr['show']);

  $args = array (
    'post_type' => 'fn-adv-rev',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'meta_query' => array(
      array(
        'key'     => 'fn_adv_rev_questions',
        'value'   => array(),
        'compare' => 'NOT IN'
      )
    ),
  );
  $advRev_query = new WP_Query( $args );
  if ( $advRev_query->have_posts() ) :
    $advRev_query->get_posts();
    while ( $advRev_query->have_posts() ) : $advRev_query->the_post();
      $fn_adv_rev_ratings = get_post_meta( get_the_ID(), 'fn_adv_rev_questions' );
      $fn_adv_rev_ratings = $fn_adv_rev_ratings[0];
      if(is_array($fn_adv_rev_ratings) && count($fn_adv_rev_ratings)){
        $fn_adv_rev_rating = round(array_sum($fn_adv_rev_ratings) / count($fn_adv_rev_ratings));
        $ratingValue = $fn_adv_rev_rating;
      }
    endwhile;

    $count = count($advRev_query->posts);
    $company = do_shortcode('[firmenname]');
    $max = "5.00";

    if ($count > 0) {
      $reviewsFound = true;
      $ratingValue = $ratingValue / $count;
      $ratingValue = round( $ratingValue, 2, PHP_ROUND_HALF_UP);
    }
    wp_reset_postdata();
  endif;

  if($showSnippet){
    echo '<span>'. $company .' | '. $ratingValue. ' von ' . $max .' Sternen <br>' . $count . ' Bewertungen gesamt</span>';
  }else{
    if(!is_front_page()){
      if($reviewsFound) {
        $fn_snippet = '<script type="application/ld+json">';
        $fn_snippet .= '{';
        $fn_snippet .= '"@context": "http://schema.org",';
        $fn_snippet .= '"@type": "Organization",';
        $fn_snippet .= '"name": "'.$company.'",';
        $fn_snippet .= '"aggregateRating" : {';
        $fn_snippet .= '"@type": "AggregateRating",';
        $fn_snippet .= '"ratingValue" : "'.$ratingValue.'",';
        $fn_snippet .= '"bestRating" : "'.$max.'",';
        $fn_snippet .= '"ratingCount" : "'.$count.'"';
        $fn_snippet .= '}}';
        $fn_snippet .= '</script>';
        echo $fn_snippet;
      }
    }
  }


  return ob_get_clean();
}
