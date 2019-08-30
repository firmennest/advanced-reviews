<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('advanced-reviews-form','fn_adv_rev_form');
function fn_adv_rev_form($attr)
{
  ob_start();
  $settingsGeneral = get_option('fn_adv_rev_setting[general]');
  ?><form class="fnadvrev-form fn-adv-rev-form-review" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST">
    <input type="hidden" name="action" value="fnarsend">
    <div class="fnadvrev-grid fnadvrev-flex fnadvrev-flex-middle">
      <div class="fnadvrev-width-1-3@m">
        <label class="fnadvrev-form-label"><?php
          if(empty($settingsGeneral['label']['name'])){
            _e('Name', 'firmennest | Advanced Reviews');
          }else{
            _e($settingsGeneral['label']['name'], 'firmennest | Advanced Reviews');
          }
          ?><span class="fn-adv-rev-required-sign fnadvrev-text-danger">*</span>
        </label>
      </div>
      <div class="fnadvrev-width-2-3@m">
        <div class="fnadvrev-form-controls"><input name="fnAdvReview[name]" class="fnadvrev-input fn-adv-rev-required" type="text" placeholder=""></div>
      </div>
    </div><?php
    $fields = get_option('fn_adv_rev_setting[fields]');
    if(is_array($fields)){
      foreach ($fields as $key => $field) {
        ?><div class="fnadvrev-grid">
          <div class="fnadvrev-width-1-3@m">
            <label class="fnadvrev-form-label"><?php echo $field['label']; ?><?php if($field['required']) echo '<span class="fn-adv-rev-required-sign fnadvrev-text-danger">*</span>'; ?></label>
          </div>
          <div class="fnadvrev-width-2-3@m">
            <div class="fnadvrev-form-controls">
              <input type="text" name="fnAdvReview[fields][<?php echo $key; ?>][label]" class="fnadvrev-input <?php if($field['required']) echo 'fn-adv-rev-required'; ?>">
              <input type="hidden" name="fnAdvReview[fields][<?php echo $key; ?>][type]" value="<?php echo $field['type']; ?>">
              <input type="hidden" name="fnAdvReview[fields][<?php echo $key; ?>][required]" value="<?php echo $field['required']; ?>">
            </div>
          </div>
        </div><?php
      }
    }
    $questions = get_option('fn_adv_rev_setting[questions]');
    if(is_array($questions)){
      if(!empty($settingsGeneral['headline']['questions'])){
        ?><div class="fnadvrev-h3"><?php _e($settingsGeneral['headline']['questions'], 'firmennest | Advanced Reviews'); ?></div><?php
      }
      foreach ($questions as $key => $value) {
        ?><div class="fnadvrev-grid fnadvrev-flex fnadvrev-flex-middle">
          <div class="fnadvrev-width-1-3@m">
            <label class="fnadvrev-form-label"><?php _e($value, 'firmennest | Advanced Reviews') ?></label>
          </div>
          <div class="fnadvrev-width-2-3@m fnadvrev-text-left fnadvrev-text-right@m">
            <div class="fnadvrev-form-controls fn-adv-rev-stars-selection">
              <input class="fn-adv-rev-hidden-stars fn-adv-rev-required" name="fnAdvReview[questions][<?php echo $key; ?>]" type="hidden" value="3"><?php
              $formStars = new fnAdvReview;
              echo $formStars->getStars(5);
            ?></div>
          </div>
        </div><?php
      }
    }
    ?><div class="fnadvrev-grid">
      <div class="fnadvrev-width-1-3@m">
        <label class="fnadvrev-form-label"><?php
          if(empty($settingsGeneral['label']['message'])){
            _e('Nachricht', 'firmennest | Advanced Reviews');
          }else{
            _e($settingsGeneral['label']['message'], 'firmennest | Advanced Reviews');
          }
          ?><span class="fn-adv-rev-required-sign fnadvrev-text-danger">*</span>
        </label>
      </div>
      <div class="fnadvrev-width-2-3@m">
        <div class="fnadvrev-form-controls">
          <textarea class="fnadvrev-textarea fn-adv-rev-required" name="fnAdvReview[content]" rows="4"></textarea>
        </div>
      </div>
    </div>
    <div class="fnadvrev-grid">
      <div class="fnadvrev-width-1-1 fnadvrev-text-right">
        <button class="fnadvrev-button fnadvrev-button-primary fn-adv-rev-submit-form" type="submit" name="button"><?php
          if(empty($settingsGeneral['label']['send'])){
            _e('Bewertung absenden', 'firmennest | Advanced Reviews');
          }else{
            _e($settingsGeneral['label']['send'], 'firmennest | Advanced Reviews');
          }
        ?></button>
      </div>
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
