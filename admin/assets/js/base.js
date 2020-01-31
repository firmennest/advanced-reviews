function fn_adv_rev_add_field($btn,name){
  $fieldset = $btn.prev('fieldset')
  var key = $fieldset.find('> .fn_adv_rev_add_field_frame').length + 1;
  var $frame = $fieldset.find('> .fn_adv_rev_add_field_frame').last().clone();
  $frame.find('input, select').each(function(){
    var newName = jQuery(this).attr('name').replace(/\d+/g, key);
    jQuery(this).attr('name', newName).attr('value', '');
  });
  $fieldset.append($frame.prop('outerHTML'));
}
