<?php
add_action('wp_ajax_fnarsend', 'fnAdvReview_send');
add_action('wp_ajax_nopriv_fnarsend', 'fnAdvReview_send');
function fnAdvReview_send(){
  $fnAdvReview = $_POST['fnAdvReview'];
  $fnAdvReviewMeta = array();
  $fnAdvReviewMeta['title'] .= $fnAdvReview['title'];
  $fnAdvReviewMeta['value'] .= $fnAdvReview['stars'];


  $fnAdvReviewQuestions = $fnAdvReview['questions'];

  $fnAdvReviewFields = $fnAdvReview['fields'];


  $fn_adv_rev_post = array(
    'post_type' 		=> 'fn-adv-rev',
    'post_title'    => $fnAdvReview['name'],
    'post_content'  => $fnAdvReview['content'],
    'post_status'   => 'draft',
    'post_author'   => 1,
    'post_date'			=> date('Y-m-d H:i'),
    'meta_input' => array(
      'fn_adv_rev_rating' => $fnAdvReviewMeta,
      'fn_adv_rev_questions' => $fnAdvReviewQuestions,
      'fn_adv_rev_fields' => $fnAdvReviewFields,
    )
  );
  wp_insert_post( $fn_adv_rev_post );
	die();
}

add_action( 'wp_ajax_fn_adv_rev_setting_get_image', 'fn_adv_rev_setting_get_image'   );
function fn_adv_rev_setting_get_image() {
    if(isset($_GET['id']) ){
        $image = wp_get_attachment_image( filter_input( INPUT_GET, 'id', FILTER_VALIDATE_INT ), 'thumbnail', false, array( 'id' => 'fn_adv_rev_setting-preview-image' ) );
        $data = array(
            'image'    => $image,
        );
        wp_send_json_success( $data );
    } else {
        wp_send_json_error();
    }
}
