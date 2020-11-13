<?php
add_action('wp_ajax_fnarsend', 'fnAdvReview_send');
add_action('wp_ajax_nopriv_fnarsend', 'fnAdvReview_send');
function fnAdvReview_send(){
  $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  $fnAdvReview = $_POST['fnAdvReview'];
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
      'fn_adv_rev_questions' => $fnAdvReviewQuestions,
      'fn_adv_rev_fields' => $fnAdvReviewFields,
    )
  );
  if(!empty(trim($fnAdvReview['name'])) &&  !empty(trim($fnAdvReview['content']))){
    $posted = wp_insert_post( $fn_adv_rev_post );
    $settingsGeneral = get_option('fn_adv_rev_setting[general]');
    if($posted && isset($settingsGeneral['notificationmail']) && is_email($settingsGeneral['notificationmail'])){

      $link = get_edit_post_link($posted);

      $mailIntro = "Sie haben eine neue Bewertung von <strong>{$fnAdvReview['name']}</strong> erhalten.";
      $mailContent = "Über diesen Link: <a href='{$link}'>{$link}</a> gelangen Sie zur Bewertung.";

      $to = $settingsGeneral['notificationmail'];
      $subject = 'Sie haben eine neue Bewertung erhalten | ' . get_bloginfo('name');
      $body = $mailIntro . '<br /><br /><br />' . $mailContent;

      $headers = array('Content-Type: text/html; charset=UTF-8');

      wp_mail( $to, $subject, $body, $headers );
    }
  }
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
