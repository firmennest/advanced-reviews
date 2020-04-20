jQuery(document).ready(function($) {

  jQuery('input#fn_adv_rev_setting_media_manager').click(function(e) {
    e.preventDefault();
    var image_frame;
    if (image_frame) {
      image_frame.open();
    }
    // Define image_frame as wp.media object
    image_frame = wp.media({
      title: 'Select Media',
      multiple: false,
      library: {
        type: 'image',
      }
    });

    image_frame.on('close', function() {
      // On close, get selections and save to the hidden input
      // plus other AJAX stuff to refresh the image preview
      var selection = image_frame.state().get('selection');
      var gallery_ids = new Array();
      var index = 0;
      selection.each(function(attachment) {
        gallery_ids[index] = attachment['id'];
        index++;
      });
      var ids = gallery_ids.join(",");
      jQuery('input#fn_adv_rev_setting_image_id').val(ids);
      fn_adv_rev_setting_reload_image(ids);
    });

    image_frame.on('open', function() {
      // On open, get the id from the hidden input
      // and select the appropiate images in the media manager
      var selection = image_frame.state().get('selection');
      var ids = jQuery('input#fn_adv_rev_setting_image_id').val().split(',');
      ids.forEach(function(id) {
        var attachment = wp.media.attachment(id);
        attachment.fetch();
        selection.add(attachment ? [attachment] : []);
      });

    });
    image_frame.open();
  });
  jQuery('input#fn_adv_rev_setting_media_delete').click(function(e) {
    e.preventDefault();
    jQuery('input#fn_adv_rev_setting_image_id').val('');
    fn_adv_rev_setting_reload_image('');
  });
});

function fn_adv_rev_setting_reload_image(the_id) {
  var data = {
    action: 'fn_adv_rev_setting_get_image',
    id: the_id
  };
  jQuery.get(ajaxurl, data, function(response) {
    if (response.success === true) {
      jQuery('#fn_adv_rev_setting-preview-image').replaceWith(response.data.image);
    }
  });
}
