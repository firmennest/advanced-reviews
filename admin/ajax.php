<?php
add_action('wp_ajax_fnarsend', 'fnAdvReview_send');
add_action('wp_ajax_nopriv_fnarsend', 'fnAdvReview_send');
function fnAdvReview_send(){
  $fnAdvReview = $_POST['fnAdvReview'];
  $fnAdvReviewMeta = array();
  $fnAdvReviewMeta['title'] .= $fnAdvReview['title'];
  $fnAdvReviewMeta['value'] .= $fnAdvReview['stars'];
  $fn_adv_rev_post = array(
    'post_type' 		=> 'fn-adv-rev',
    'post_title'    => $fnAdvReview['name'],
    'post_content'  => $fnAdvReview['content'],
    'post_status'   => 'draft',
    'post_author'   => 1,
    'post_date'			=> date('Y-m-d H:i'),
    'meta_input' => array(
      'fn_adv_rev_rating' => $fnAdvReviewMeta,
    )
  );
  wp_insert_post( $fn_adv_rev_post );
	die();
}
