<?php

defined( 'ABSPATH' ) || exit;

add_shortcode('advanced-reviews-form','fn_adv_rev_form');
function fn_adv_rev_form($attr)
{
  ob_start();
  ?><form class="uk-form" action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST">
    <input type="hidden" name="action" value="fnarsend">
    <div class="uk-margin-bottom">
        <label class="uk-form-label"><?php _e('Name', 'firmennest | Advanced Reviews') ?></label>
        <div class="uk-form-controls"><input name="fnAdvReview[name]" class="uk-input fn-adv-rev-required" type="text" placeholder=""></div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label"><?php _e('Titel', 'firmennest | Advanced Reviews') ?></label>
        <div class="uk-form-controls"><input name="fnAdvReview[title]" class="uk-input fn-adv-rev-required" type="text" placeholder=""></div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label"><?php _e('Bewertung', 'firmennest | Advanced Reviews') ?></label>
        <div class="uk-form-controls fn-adv-rev-stars-selection">
          <input class="fn-adv-rev-hidden-stars fn-adv-rev-required" name="fnAdvReview[stars]" type="hidden" value="3"><?php
          $formStars = new fnAdvReview;
          echo $formStars->getStars(3);
        ?></div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label"><?php _e('Nachricht', 'firmennest | Advanced Reviews') ?></label>
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
