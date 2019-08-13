<?php

defined( 'ABSPATH' ) || exit;


class fnAdvReview {

    function getMeta($id){
      $fn_adv_rev_rating = get_post_meta( $id, 'fn_adv_rev_rating', true );
      if(is_array($fn_adv_rev_rating) && count($fn_adv_rev_rating)){
        return $fn_adv_rev_rating;
      }else{
        return false;
      }
    }



    function getStars($ratingStars){
      $ratingStars = intVal($ratingStars);
      ?><div class="fn-adv-rev-stars uk-text-warning uk-text-large">
        <?php
          for ($i=0; $i < $ratingStars; $i++) {
            ?><span><i class="fas fa-star" fn-ar-value="<?php echo $i; ?>"></i></span><?php
          }
          for ($i=0; $i < 5 - $ratingStars; $i++) {
            ?><span><i class="fal fa-star" fn-ar-value="<?php echo $i; ?>"></i></span><?php
          }
        ?>
      </div><?php
    }

    function getTitle(){
      $ratingTitle = $fn_adv_rev_rating['title'];
      if($ratingTitle){
        ?><div class="fn-adv-rev-title uk-h3"><?php echo $ratingTitle; ?></div><?php
      }
    }
}
