jQuery(document).ready(function(){
	
	jQuery('body').on('click','#woosasc_share_cart',function(e){
		
		jQuery('body').addClass("woosasc_sharecart_popup_body");
		jQuery('body').append('<div class="woosasc_loading"><img src="'+ woosasc_js_data.woosasc_loader +'/images/loader.gif" class="woosasc_loader"></div>');
		var loading = jQuery('.woosasc_loading');
		loading.show();

		var current = jQuery(this);
		jQuery.ajax({
			url:woosasc_js_data.ajax_url,
			type:'POST',
			data:'action=sharecart_popup',
			success : function(response) {
				var loading = jQuery('.woosasc_loading');
				loading.remove();
				jQuery("#woosasc_sharecart_popup").fadeIn(300);
				jQuery("#woosasc_sharecart_popup").html(response);
			},
			error: function() {
				alert('Error occured');
			}
		});
	   return false;
   	});

	var modal = document.getElementById("woosasc_sharecart_popup");
	var span = document.getElementsByClassName("woosasc_scp_close")[0];
	jQuery(document).on('click','.woosasc_scp_close',function(){
		jQuery("#woosasc_sharecart_popup").fadeOut(300);
		jQuery('body').removeClass("woosasc_sharecart_popup_body");
	});
	window.onclick = function(event) {
	  if (event.target == modal) {
		jQuery("#woosasc_sharecart_popup").fadeOut(300);
		jQuery('body').removeClass("woosasc_sharecart_popup_body");
	  }
	}

	jQuery('body').on('click','#woosasc_copyclipboard',function(e){
		
		var cartLink = jQuery("#woosasc_copylink").val();
		var $temp = jQuery("<input>");
		jQuery("body").append($temp);
		$temp.val(cartLink).select();
		document.execCommand("copy");
		$temp.remove();

		jQuery('#woosac_scp_ul').html('Link Copied');
		setTimeout(function() {
			jQuery("#woosasc_sharecart_popup").fadeOut(300); 
			jQuery('body').removeClass("woosasc_sharecart_popup_body");
		}, 2000);
		return false;
	});

	jQuery('body').on('click','#woosasc_save',function(e){
		var cartHash = jQuery("#woosasc_cart_hash_save").val();
		jQuery.ajax({
			url:woosasc_js_data.ajax_url,
			type:'POST',
			data:'action=save_cart_popup&carthash='+cartHash,
			success : function(response) {
				jQuery(".woosasc_scp_inner_div").html(response);
			},
			error: function() {
				alert('Error occured');
			}
		});
		return false;
	});

	jQuery('body').on('click','#wssc_sv_btn',function(e){
		var cartHash = jQuery("#wssc_sv_hash").val();
		var cartTitle = jQuery("#wssc_sv_title").val();
		var cartDesc = jQuery("#wssc_sv_desc").val();
		if(cartTitle != '' && cartDesc != '') {
			jQuery('p.ocsasc_error_sc').hide(300);
			jQuery.ajax({
				url:woosasc_js_data.ajax_url,
				type:'POST',
				data:'action=save_cart_func&carthash='+cartHash+'&carttitle='+cartTitle+'&cartdesc='+cartDesc,
				success : function(response) {
					jQuery('.savecart_ul').html(response);
					setTimeout(function() {
						jQuery("#woosasc_sharecart_popup").fadeOut(300); 
						jQuery('body').removeClass("woosasc_sharecart_popup_body");
					}, 2000);
				},
				error: function() {
					alert('Error occured');
				}
			});
		}else{
			jQuery('p.ocsasc_error_sc').show(300);
		}
		return false;
	});

	jQuery('body').on('click','#woosasc_send_mail',function(e){
		var cartHash = jQuery("#woosasc_cart_hash_email").val();
		jQuery.ajax({
			url:woosasc_js_data.ajax_url,
			type:'POST',
			data:'action=send_mail_popup&carthash='+cartHash,
			success : function(response) {
				jQuery(".woosasc_scp_inner_div").html(response);
			},
			error: function() {
				alert('Error occured');
			}
		});
		return false;
	});

	jQuery('body').on('click','#wssc_eml_btn',function(){
		
		var email_data = jQuery('#wssc_eml_form').serialize();
		var emailAdd = jQuery("#wssc_eml_add").val();
		var emailSub = jQuery("#wssc_eml_sub").val();
		var emailContent = jQuery("#wssc_eml_cont").val();

		if(emailAdd != '' && emailSub != '' && emailContent != '') {
			jQuery('.ocsasc_error_mail').hide(300);
			jQuery.ajax({
				url:woosasc_js_data.ajax_url,
				type:'POST',
				data: email_data,
				success : function(response) {
					jQuery('.sendmail_ul').html(response);
					setTimeout(function() {
						jQuery("#woosasc_sharecart_popup").fadeOut(300); 
						jQuery('body').removeClass("woosasc_sharecart_popup_body");
					}, 2000);
				},
				error: function() {
					alert('Error occured');
				}
			});
		}else{
			jQuery('.ocsasc_error_mail').show(300);
		}
		return false;
	});


});
