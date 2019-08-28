<?php

defined( 'ABSPATH' ) || exit;


class fnAdvReview {

    function getRating($id){
      $fn_adv_rev_ratings = get_post_meta( get_the_ID(), 'fn_adv_rev_questions' );
      $fn_adv_rev_ratings = $fn_adv_rev_ratings[0];
      if(is_array($fn_adv_rev_ratings) && count($fn_adv_rev_ratings)){
        $fn_adv_rev_rating = round(array_sum($fn_adv_rev_ratings) / count($fn_adv_rev_ratings));
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
}
