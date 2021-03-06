<?php

defined( 'ABSPATH' ) || exit;

function fn_adv_rev_post_type() {

  $labels = array(
    'name'               => _x( 'Advanced Reviews', 'post type general name', 'firmennest | Advanced Reviews' ),
		'singular_name'      => _x( 'Review', 'post type singular name', 'firmennest | Advanced Reviews'),
    'menu_name'          => _x( 'Advanced Reviews', 'admin menu', 'firmennest | Advanced Reviews' ),
    'name_admin_bar'     => _x( 'Review', 'add new on admin bar', 'firmennest | Advanced Reviews' ),
    'add_new'            => _x( 'Add New', 'book', 'firmennest | Advanced Reviews' ),
    'add_new_item'       => __( 'Add New Review', 'firmennest | Advanced Reviews' ),
    'new_item'           => __( 'New Review', 'firmennest | Advanced Reviews' ),
    'edit_item'          => __( 'Edit Review', 'firmennest | Advanced Reviews' ),
    'view_item'          => __( 'View Review', 'firmennest | Advanced Reviews' ),
    'all_items'          => __( 'All Reviews', 'firmennest | Advanced Reviews' ),
    'search_items'       => __( 'Search Reviews', 'firmennest | Advanced Reviews' ),
    'parent_item_colon'  => __( 'Parent Reviews:', 'firmennest | Advanced Reviews' ),
    'not_found'          => __( 'No reviews found.', 'firmennest | Advanced Reviews' ),
    'not_found_in_trash' => __( 'No reviews found in Trash.', 'firmennest | Advanced Reviews' )

  );
  $args = array(
    'labels'                => $labels,
    'supports'              => array(
                              'title',
                              'editor',
                              'revisions',
                              'thumbnail',
                            ),
    'hierarchical'          => false,
    'public'                => false,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 25,
    'menu_icon'             => 'dashicons-id',
    'show_in_admin_bar'     => false,
    'show_in_nav_menus'     => false,
    'can_export'            => true,
    'has_archive'           => false,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true,
    'capability_type'       => 'post',
  );
  register_post_type( 'fn-adv-rev', $args );

  $settingsGeneral = get_option('fn_adv_rev_setting[general]');
  if (isset($settingsGeneral['taxonomy']) && $settingsGeneral['taxonomy'] === 'on'){
    register_taxonomy(
		'Review Category',
		'fn-adv-rev',
		array(
			'label' => __( 'Review Category' ),
			'hierarchical' => true,
      'public' => false,
      'show_ui' => true
		)
	);
  }
}
add_action( 'init', 'fn_adv_rev_post_type', 0 );

function fn_adv_rev_admin_css() {
  if ( get_current_screen()->post_type === 'fn-adv-rev' ){
    wp_enqueue_style( 'fn-adv-rev-css', FN_ADV_REV_URL . 'admin/assets/css/main.css', array(), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/css/main.css'), false);
    wp_enqueue_style( 'fn-adv-rev-wp-base-css', FN_ADV_REV_URL . 'admin/assets/css/fn-adv-rev-wp-base.css', array(), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/css/fn-adv-rev-wp-base.css'), false);
  }
}
add_action('current_screen', 'fn_adv_rev_admin_css');

add_action( 'admin_menu', 'fn_adv_rev_admin_menu' );
function fn_adv_rev_admin_menu() {
	add_submenu_page( 'edit.php?post_type=fn-adv-rev', 'Documentation', 'Documentation', 'manage_options', 'fn-adv-rev-docu', 'fn_adv_rev_admin_docu'  );
	$settings_page = add_submenu_page( 'edit.php?post_type=fn-adv-rev', 'Settings', 'Settings', 'manage_options', 'fn-adv-rev-settings', 'fn_adv_rev_admin_settings'  );
  add_action( 'load-' . $settings_page, 'fn_adv_rev_js_admin_load' );
}
function fn_adv_rev_js_admin_load(){
  add_action( 'admin_enqueue_scripts', 'fn_adv_rev_admin_js' );
}

function fn_adv_rev_admin_js() {
  wp_enqueue_script( 'fn-adv-rev-fw-js', FN_ADV_REV_URL . 'admin/assets/framework/uikit/js/uikit.min.js', array('jquery'), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/framework/uikit/js/uikit.min.js'), false);
  wp_enqueue_script( 'fn-adv-rev-fw-js-icons', FN_ADV_REV_URL . 'admin/assets/framework/uikit/js/uikit-icons.min.js', array('fn-adv-rev-fw-js'), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/framework/uikit/js/uikit-icons.min.js'), false);

  wp_enqueue_media();
  wp_enqueue_script( 'fn_adv_rev_js_media', FN_ADV_REV_URL . 'admin/assets/js/media-min.js', array('jquery'), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/js/media-min.js') );
  wp_enqueue_script( 'fn_adv_rev_js_base', FN_ADV_REV_URL . 'admin/assets/js/base.js', array('jquery'), filemtime( FN_ADV_REV_TEMPLATE_DIR . 'admin/assets/js/base.js') );
}
// add_action('admin_enqueue_scripts', 'fn_adv_rev_admin_js');


// CSS Files
function fn_adv_rev_assets() {
  if ( !is_admin() ) {
    wp_register_style( 'fnadvrev-loader', FN_ADV_REV_URL . 'assets/css/fnadvrev-loader.css', array(), filemtime(FN_ADV_REV_TEMPLATE_DIR . 'assets/css/fnadvrev-loader.css'), false);
    wp_enqueue_script( 'fn-adv-rev-base', FN_ADV_REV_URL . 'assets/js/base-min.js', array(), filemtime(FN_ADV_REV_TEMPLATE_DIR . 'assets/js/base-min.js'), true);
  }
}
add_action( 'wp_enqueue_scripts', 'fn_adv_rev_assets' );

function fn_adv_rev_add_footer_styles() {
  if ( !is_admin() ) {
    wp_enqueue_style('fnadvrev-loader');
  }
};
add_action( 'get_footer', 'fn_adv_rev_add_footer_styles' );

add_action('add_meta_boxes', 'fn_adv_rev_add_meta_boxes', 1);
function fn_adv_rev_add_meta_boxes() {
	$screen = 'fn-adv-rev';

  $fields = get_option('fn_adv_rev_setting[fields]');
  add_meta_box(
    'fn_adv_rev_rating_box_fields',
    __( 'Felder', 'firmennest | Advanced Reviews' ),
    'fn_adv_rev_get_fields',
    $screen,
    'advanced',
    'high'
  );

  $questions = get_option('fn_adv_rev_setting[questions]');
  add_meta_box(
    'fn_adv_rev_rating_box_questions',
    __( 'Fragen', 'firmennest | Advanced Reviews' ),
    'fn_adv_rev_get_questions',
    $screen,
    'advanced',
    'high'
  );
}
function fn_adv_rev_get_questions($post){
  $questions = get_option('fn_adv_rev_setting[questions]');
  if(is_array($questions) && count($questions) > 0  ){
    ?><div class="uk-form uk-padding-small"><?php
    $fn_adv_rev_questions = get_post_meta($post->ID, 'fn_adv_rev_questions', true);
    foreach ($questions as $key => $value) {
      ?><div class="uk-margin">
          <label for="<?php echo 'fn_adv_rev_questions'.'['.$key.']'; ?>" class="uk-h5"><?php echo $value; ?></label>
          <?php wp_nonce_field( 'fn_adv_rev_questions_save['.$key.']', 'fn_adv_rev_questions_save_nonce['.$key.']' ); ?>
          <input id="<?php echo 'fn_adv_rev_questions'.'['.$key.']'; ?>" name="<?php echo 'fn_adv_rev_questions'.'['.$key.']'; ?>" type="number" value="<?php echo $fn_adv_rev_questions[$key] ?>" min="1" max="5">
      </div><?php
    }
    ?></div><?php
  }else{
    ?><div class="uk-padding-small"><div class="uk-alert uk-alert-warning uk-text-center">
      <?php _e('Legen Sie in den Einstellungen mindestens eine Frage an, damit Sie bewertet werden können.'); ?><br /> <a href="<?php echo admin_url(); ?>edit.php?post_type=fn-adv-rev&page=fn-adv-rev-settings" class="uk-button uk-button-secondary uk-button-small uk-margin-top">Einstellungen</a></div></div><?php
  }
}
function fn_adv_rev_get_fields($post){
  $fields = get_option('fn_adv_rev_setting[fields]');
  if(is_array($fields) && count($fields) > 0 ){
    ?><div class="uk-form uk-padding-small"><?php
    $fn_adv_rev_fields = get_post_meta($post->ID, 'fn_adv_rev_fields', true);
    foreach ($fields as $key => $field) {
      ?><div class="uk-margin">
          <label for="<?php echo 'fn_adv_rev_fields'.'['.$key.']'; ?>" class="uk-h5"><?php echo $field['label']; ?></label>
          <input id="<?php echo 'fn_adv_rev_fields'.'['.$key.']'; ?>" name="<?php echo 'fn_adv_rev_fields'.'['.$key.'][value]'; ?>" type="<?php echo $field['type']; ?>" value="<?php if(is_array($fn_adv_rev_fields)) echo $fn_adv_rev_fields[$key]['value']; ?>">
          <?php wp_nonce_field( 'fn_adv_rev_fields_save['.$key.']', 'fn_adv_rev_fields_save_nonce['.$key.']' ); ?>
      </div><?php
    }
    ?></div><?php
  }else{
    ?><div class="uk-padding-small"><div class="uk-alert uk-alert-warning uk-text-center">
      <?php _e('Legen Sie in den Einstellungen Felder an, um zusätzliche Informationen abzufragen. Es wird ansonsten nur der Name und eine Nachricht abgefragt.'); ?><br /> <a href="<?php echo admin_url(); ?>edit.php?post_type=fn-adv-rev&page=fn-adv-rev-settings" class="uk-button uk-button-secondary uk-button-small uk-margin-top">Einstellungen</a></div></div><?php
  }
}
add_action('save_post', 'fn_adv_rev_save_post');
function fn_adv_rev_save_post($post_id) {
  $saveError = 0;

  //Save Questions
  if ( isset( $_POST['fn_adv_rev_questions_save_nonce'] ) ){
    $fn_adv_rev_questions = array();
    foreach ($_POST['fn_adv_rev_questions_save_nonce'] as $key => $value ) {
      if ( isset( $value ) ){
        if (wp_verify_nonce( $_POST['fn_adv_rev_questions_save_nonce'][$key], 'fn_adv_rev_questions_save['.$key.']' ) ){
          $fn_adv_rev_questions[$key] = $_POST['fn_adv_rev_questions'][$key];
        }
      }
    }
    if(isset($fn_adv_rev_questions) && is_array($fn_adv_rev_questions)){
      update_post_meta($post_id, 'fn_adv_rev_questions', $fn_adv_rev_questions);
    }
  }

  //Save Fields
  if ( isset( $_POST['fn_adv_rev_fields_save_nonce'] ) ){
    $fn_adv_rev_fields = array();
    foreach ($_POST['fn_adv_rev_fields_save_nonce'] as $key => $value ) {
      if ( isset( $value ) ){
        if ( wp_verify_nonce( $_POST['fn_adv_rev_fields_save_nonce'][$key], 'fn_adv_rev_fields_save['.$key.']' ) ){
          $fn_adv_rev_fields[$key] = $_POST['fn_adv_rev_fields'][$key];
        }
      }
    }
    if(isset($fn_adv_rev_fields) && is_array($fn_adv_rev_fields)){
      update_post_meta($post_id, 'fn_adv_rev_fields', $fn_adv_rev_fields);
    }
  }
  return $post_id;
}
