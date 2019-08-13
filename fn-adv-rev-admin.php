<?php

defined( 'ABSPATH' ) || exit;

function fn_adv_rev_post_type() {

  $labels = array(
    'name'               => _x( 'Advanced Reviews', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Review', 'post type singular name', 'your-plugin-textdomain'),
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
                              'revisions'
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
}
add_action( 'init', 'fn_adv_rev_post_type', 0 );

function fn_adv_rev_admin_css() {
  $dirPath = plugin_dir_path( __FILE__ );
  $dirURL = plugin_dir_url( __FILE__ );

  if ( get_current_screen()->post_type === 'fn-adv-rev' ) {
    wp_register_style( 'fn-adv-rev-css', $dirURL . 'assets/css/main.css', array(), filemtime( $dirPath . 'assets/css/main.css'), false);
    wp_enqueue_style( 'fn-adv-rev-css');
  }
	if ( !is_admin() ) {
    wp_register_style( 'fn-adv-rev-css', $dirURL . 'assets/css/main.css', array(), filemtime( $dirPath . 'assets/css/main.css'), false);
    wp_enqueue_style( 'fn-adv-rev-css');
  }
}
add_action( 'wp_enqueue_styles', 'fn_adv_rev_admin_css' );
add_action('current_screen', 'fn_adv_rev_admin_css');

// CSS Files
function fn_adv_rev_css() {
	$dirPath = plugin_dir_path( __FILE__ );
  $dirURL = plugin_dir_url( __FILE__ );
  if ( !is_admin() ) {
    wp_register_style( 'fnadvrev-loader-css', $dirURL . '/assets/css/fnadvrev-loader.css', array(), filemtime($dirPath . '/assets/css/fnadvrev-loader.css'), false);
    wp_enqueue_style( 'fnadvrev-loader-css');
  }
}
add_action( 'wp_enqueue_styles', 'fn_adv_rev_css' );
add_action('init', 'fn_adv_rev_css');

function fn_adv_rev_js() {
	$dirPath = plugin_dir_path( __FILE__ );
  $dirURL = plugin_dir_url( __FILE__ );
  if ( !is_admin() ) {
    wp_register_script( 'fn-adv-rev-base-js', $dirURL . '/assets/js/base-min.js', array(), filemtime($dirPath . '/assets/js/base-min.js'), true);
    wp_enqueue_script( 'fn-adv-rev-base-js');
  }
}
add_action( 'wp_enqueue_scripts ', 'fn_adv_rev_js');
add_action( 'init', 'fn_adv_rev_js');


add_action( 'admin_menu', 'fn_adv_rev_admin_menu' );
function fn_adv_rev_admin_menu() {
	add_submenu_page( 'edit.php?post_type=fn-adv-rev', 'Documentation', 'Documentation', 'manage_options', 'fn-adv-rev-docu', 'fn_adv_rev_admin_docu'  );
	//add_submenu_page( 'edit.php?post_type=fn-adv-rev', 'Settings', 'Settings', 'manage_options', 'fn-adv-rev-settings', 'fn_adv_rev_admin_settings'  );
}

add_action('add_meta_boxes', 'fn_adv_rev_add_meta_boxes', 1);
function fn_adv_rev_add_meta_boxes() {
	$screen = 'fn-adv-rev';
	add_meta_box(
		'fn_adv_rev_rating_box',
		__( 'Rating Details', 'firmennest | Advanced Reviews' ),
		'fn_adv_rev_add_fields',
		$screen,
		'advanced',
		'high'
	);
}

function fn_adv_rev_add_fields($post) {

  $fn_adv_rev_rating = get_post_meta($post->ID, 'fn_adv_rev_rating', true);
  if($fn_adv_rev_rating){
    foreach ($fn_adv_rev_rating as $key => $value) {
      if (empty($fn_adv_rev_rating[$key]) || !$fn_adv_rev_rating[$key]) {
        $fn_adv_rev_rating[$key] = '';
      }
    }
  }else{
    $fn_adv_rev_rating = array(
      'title' => '',
      'value' => 1,
    );
    add_post_meta( $post->ID, 'fn_adv_rev_rating', $fn_adv_rev_rating , true );
  }
  $fields['title']['label'] = sprintf(
    '%s',
    'Titel'
  );
	$fields['title']['input'] = sprintf(
		'<input id="%s" name="%s" type="%s" value="%s" style="%s">',
		'fn_adv_rev_rating_title',
		'fn_adv_rev_rating[title]',
		'text',
		$fn_adv_rev_rating['title'],
    'width: 100%'
	);

  $fields['value']['label'] = sprintf(
    '%s',
    'Sterne'
  );
	$fields['value']['input'] = sprintf(
		'<input id="%s" name="%s" type="%s" value="%s" style="%s" min="1" max="5">',
		'fn_adv_rev_rating_value',
		'fn_adv_rev_rating[value]',
		'number',
		$fn_adv_rev_rating['value'],
    'width: 100%'
	);

  ?><div class="uk-form-horizontal uk-padding-small"><?php
  	foreach ($fields as $key => $field) {
      ?><div class="uk-margin">
          <label class="uk-form-label uk-h5"><?php echo $field['label']; ?></label>
          <div class="uk-form-controls">
            <?php wp_nonce_field( 'fn_adv_rev_rating_save['.$key.']', 'fn_adv_rev_rating_save_nonce['.$key.']' );
            echo $field['input'];
          ?></div>
      </div><?php
    }
  ?></div><?php
}


add_action('save_post', 'fn_adv_rev_save_post');
function fn_adv_rev_save_post($post_id) {
  if ( ! isset( $_POST['fn_adv_rev_rating_save_nonce'] ) )
    return $post_id;
  foreach ($_POST['fn_adv_rev_rating_save_nonce'] as $key => $value ) {
    if ( ! isset( $value ) )
      return $post_id;

    if ( !wp_verify_nonce( $_POST['fn_adv_rev_rating_save_nonce'][$key], 'fn_adv_rev_rating_save['.$key.']' ) )
      return $post_id;

    $fn_adv_rev_rating[$key] .= $_POST['fn_adv_rev_rating'][$key];
  }
  update_post_meta($post_id, 'fn_adv_rev_rating', $fn_adv_rev_rating);
}