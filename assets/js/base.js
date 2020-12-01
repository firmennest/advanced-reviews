(function($) {
  function fn_adv_review_showLoader(){
    $('body').addClass('no-scroll');
    $('#fnloader').fadeIn( "slow", function() {});
  }
  function fn_adv_review_hideLoader(){
    $('body').removeClass('no-scroll');
    $('#fnloader').fadeOut( "slow", function() {});
  }
  function fn_adv_review_fieldError(field){
    field.addClass('fn-adv-rev-error');
    field.addClass('uk-alert-danger');
  }
  function fn_adv_review_fieldSuccess(field){
    field.removeClass('fn-adv-rev-error');
    field.removeClass('uk-alert-danger');
  }
  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
  function fnValidation($form){
    $form.find(".fn-adv-rev-error").each(function(){
      fn_adv_review_fieldSuccess($(this));
    });
    $form.find(".fn-adv-rev-required").each(function(){
      if($(this).hasClass('fn-adv-rev-number')){
        var fnNumber = $(this).val();
        if( !isNaN( parseFloat( fnNumber ) ) ){
          fnNumber = parseFloat(fnNumber.replace(',','.').replace(' ',''));
          fnNumber = fnNumber.toFixed(2);
          if(!isNumeric(fnNumber)){
            fn_adv_review_fieldError($(this));
          }else{
            fn_adv_review_fieldSuccess($(this));
            $(this).val(fnNumber);
          }
        }else{
          fn_adv_review_fieldError($(this));
        }
      }else if($(this).val() == ''){
        fn_adv_review_fieldError($(this));
      }else{
        fn_adv_review_fieldSuccess($(this));
      }
    });
    if($form.find('.fn-adv-rev-error').length > 0){
      return false;
    }else{
      return true;
    }
  }
  $( document ).ready(function() {
    $('.fn-adv-rev-submit-form').closest('form').submit(function(e) {
      var $form = $(this);
      e.preventDefault();
      if(fnValidation($(this)) === 0){
        UIkit.notification("Bitte wählen Sie mind. eine Kategorie aus", {status:'danger', pos: 'bottom-center'})
        return;
      }else if(!fnValidation($(this))){
        UIkit.notification("Bitte füllen Sie alle Pflichtfelder aus", {status:'danger', pos: 'bottom-center'})
        return;
      }

      var url = $(this).attr('action');
      var fnAdvRatingNewData = $(this).serialize();
      $.ajax({
        url: url,
        type: 'POST',
        data: fnAdvRatingNewData,
        beforeSend: function(){
         fn_adv_review_showLoader();
        },
        complete: function(){
         fn_adv_review_hideLoader();
        }
      }).done(function(response){
        UIkit.notification("Ihre Bewertung wurde abgeschickt.", {status:'success', pos: 'bottom-center'})
        $form.trigger("reset");
      }).fail(function(response){
        console.log(response);
      });
    });
  });
}(jQuery));
