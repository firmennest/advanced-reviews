<?php

defined( 'ABSPATH' ) || exit;

function fn_adv_rev_fields_pos($pos){
  $fields = get_option('fn_adv_rev_setting[fields]');
  $fieldsMeta = get_post_meta( get_the_ID() ,'fn_adv_rev_fields');
  if($fieldsMeta){
    $extractedFields = array();
    foreach ($fieldsMeta as $field) {
      foreach ($field as $key => $value) {
        if(array_key_exists($key, $fields)){
          if($fields[$key]['position'] === $pos){
            $keyTitle = $fields[$key]['label'];
            $extractedFields[$keyTitle] = $value;
          }
        }
      }
    }
    //var_dump($extractedFields);
    if(is_array($extractedFields) && count($extractedFields) > 0){
      $positionsWrapper = array('topText', 'bottomText', 'topName', 'bottomName');
      if(in_array($pos, $positionsWrapper)){
        ?><div class="fn-adv-rev-field-<?php echo $pos; ?> uk-display-inline-block"><?php
      }
      foreach ($extractedFields as $label => $value) {
        if (!empty($value['value'])) {
          ?><span class="fn-adv-rev-field-<?php echo sanitize_title($label); ?> uk-text-meta"><?php echo $value['value']; ?></span><?php
        }
      }
      if(in_array($pos, $positionsWrapper)){
        ?></div><?php
      }
    }
  }
}
