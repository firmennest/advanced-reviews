<?php

/**
 * @package fn_adv_rev
 * @version 1.0.3
 */

/*
* Plugin Name: Advanced Reviews
* Version: 1.0.2
* Plugin URI: https://www.firmennest.de/
* Description: Erstelle und zeige Bewertungen in verschieden Styles.
* Author: nest online GmbH
* Author URI: https://www.firmennest.de/
*/

defined( 'ABSPATH' ) || exit;

$url = plugin_dir_url(__FILE__);
$dir = plugin_dir_path(__FILE__);

define('FN_ADV_REV_URL',$url);
define('FN_ADV_REV_TEMPLATE_DIR',$dir);

require_once('fn-adv-rev-admin.php');

require_once('includes/class-far-rating.php');

require_once('includes/fn-adv-rev-functions.php');

require_once('admin/ajax.php');

require_once('admin/views/settings.php');
require_once('admin/views/docu.php');


require_once('includes/fn-adv-rev-shortcodes.php');
// require_once('views/overview.php');
// require_once('views/slider.php');

require_once('template/form.php');
require_once('template/snippet.php');


function fn_adv_rev_addLoader() {
    ?><div id="fnloader" style="display: none;">
      <div class="spinner">
        <div class="double-bounce1 uk-background-primary"></div>
        <div class="double-bounce2 uk-background-primary"></div>
      </div>
    </div><?php
}
add_action( 'wp_footer', 'fn_adv_rev_addLoader' );
