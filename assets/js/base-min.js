!function($){function fn_adv_review_fieldError(field){field.addClass("fn-adv-rev-error"),field.addClass("uk-alert-danger")}function fn_adv_review_fieldSuccess(field){field.removeClass("fn-adv-rev-error"),field.removeClass("uk-alert-danger")}function fnValidation($form){return $form.find(".fn-adv-rev-error").each((function(){fn_adv_review_fieldSuccess($(this))})),$form.find(".fn-adv-rev-required").each((function(){if($(this).hasClass("fn-adv-rev-number")){var fnNumber=$(this).val();isNaN(parseFloat(fnNumber))?fn_adv_review_fieldError($(this)):(fnNumber=(fnNumber=parseFloat(fnNumber.replace(",",".").replace(" ",""))).toFixed(2),n=fnNumber,isNaN(parseFloat(n))||!isFinite(n)?fn_adv_review_fieldError($(this)):(fn_adv_review_fieldSuccess($(this)),$(this).val(fnNumber)))}else""==$(this).val()?fn_adv_review_fieldError($(this)):fn_adv_review_fieldSuccess($(this));var n})),!($form.find(".fn-adv-rev-error").length>0)}$(document).ready((function(){$(".fn-adv-rev-submit-form").closest("form").submit((function(e){var $form=$(this);if(e.preventDefault(),0!==fnValidation($(this)))if(fnValidation($(this))){var url=$(this).attr("action"),fnAdvRatingNewData=$(this).serialize();$.ajax({url:url,type:"POST",data:fnAdvRatingNewData,beforeSend:function(){$("body").addClass("no-scroll"),$("#fnloader").fadeIn("slow",(function(){}))},complete:function(){$("body").removeClass("no-scroll"),$("#fnloader").fadeOut("slow",(function(){}))}}).done((function(response){UIkit.notification("Ihre Bewertung wurde abgeschickt.",{status:"success",pos:"bottom-center"}),$form.trigger("reset")})).fail((function(response){console.log(response)}))}else UIkit.notification("Bitte füllen Sie alle Pflichtfelder aus",{status:"danger",pos:"bottom-center"});else UIkit.notification("Bitte wählen Sie mind. eine Kategorie aus",{status:"danger",pos:"bottom-center"})}))}))}(jQuery);