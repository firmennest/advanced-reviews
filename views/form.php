<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('advanced-reviews-form','fn_adv_rev_form');
function fn_adv_rev_form($attr)
{
  ob_start();
  $settingsGeneral = get_option('fn_adv_rev_setting[general]');
  ?><form class="uk-form" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST">
    <input type="hidden" name="action" value="fnarsend">
    <div class="uk-margin-bottom">
      <label class="uk-form-label"><?php
        if(empty($settingsGeneral['label']['name'])){
          _e('Name', 'firmennest | Advanced Reviews');
        }else{
          _e($settingsGeneral['label']['name'], 'firmennest | Advanced Reviews');
        }
      ?><span class="fn-adv-rev-required-sign uk-text-danger">*</span></label>
      <div class="uk-form-controls"><input name="fnAdvReview[name]" class="uk-input fn-adv-rev-required" type="text" placeholder=""></div>
    </div><?php
    $fields = get_option('fn_adv_rev_setting[fields]');
    if(is_array($fields)){
      foreach ($fields as $key => $field) {
        ?><div class="uk-margin-bottom">
          <label class="uk-form-label"><?php echo $field['label']; ?><?php if($field['required']) echo '<span class="fn-adv-rev-required-sign uk-text-danger">*</span>'; ?></label>
          <div class="uk-form-controls">
            <input type="text" name="fnAdvReview[fields][<?php echo $key; ?>][value]" class="uk-input <?php if($field['required']) echo 'fn-adv-rev-required'; ?>">
            <input type="hidden" name="fnAdvReview[fields][<?php echo $key; ?>][type]" value="<?php echo $field['type']; ?>">
            <input type="hidden" name="fnAdvReview[fields][<?php echo $key; ?>][required]" value="<?php echo $field['required']; ?>">
          </div>
        </div><?php
      }
    }
    $questions = get_option('fn_adv_rev_setting[questions]');
    if(is_array($questions)){
      if(!empty($settingsGeneral['headline']['questions'])){
        ?><div class="uk-h3"><?php _e($settingsGeneral['headline']['questions'], 'firmennest | Advanced Reviews'); ?></div><?php
      }
      foreach ($questions as $key => $value) {
        ?><div class="uk-margin-bottom">
          <label class="uk-form-label"><?php _e($value, 'firmennest | Advanced Reviews') ?></label>
          <div class="uk-form-controls fn-adv-rev-stars-selection">
            <input class="fn-adv-rev-hidden-stars fn-adv-rev-required" name="fnAdvReview[questions][<?php echo $key; ?>]" type="hidden" value="5"><?php
            $formStars = new fnAdvReview;
            echo $formStars->getStars(5);
          ?></div>
        </div><?php
      }
    }
    ?><div class="uk-margin-bottom">
      <label class="uk-form-label"><?php
        if(empty($settingsGeneral['label']['message'])){
          _e('Nachricht', 'firmennest | Advanced Reviews');
        }else{
          _e($settingsGeneral['label']['message'], 'firmennest | Advanced Reviews');
        }
      ?><span class="fn-adv-rev-required-sign uk-text-danger">*</span></label>
      <div class="uk-form-controls">
        <textarea class="uk-textarea fn-adv-rev-required" name="fnAdvReview[content]" rows="4"></textarea>
      </div>
    </div>
    <div class="uk-margin-bottom">
        <button class="uk-button uk-button-primary fn-adv-rev-submit-form" type="submit" name="button"><?php _e('Absenden','firmennest | Advanced Reviews') ?></button>
    </div>
    <script type="text/javascript">
      (function($) {
        function fn_adv_rev_markStars(thisEle){
          thisEle.addClass('fas').removeClass('fal').parent().addClass('fn-adv-rev-selected');
          thisEle.parent().prevAll().addClass('fn-adv-rev-selected').find('i').addClass('fas').removeClass('fal');
          thisEle.parent().nextAll().removeClass('fn-adv-rev-selected').find('i').addClass('fal').removeClass('fas');
          thisEle.closest('.fn-adv-rev-stars-selection').find('.fn-adv-rev-hidden-stars').val(thisEle.closest('.fn-adv-rev-stars-selection').find('.fn-adv-rev-selected').length);
        }
        $('.fn-adv-rev-stars-selection').find('.fn-adv-rev-stars').each(function(){
          var stars = $(this);
          stars.find('span').click(function(){
            fn_adv_rev_markStars($(this).find('i'));
          });
        });
      })(jQuery);
    </script>
  </form><?php
  return ob_get_clean();
}
