// have to look for FBL_LANG_DEFINED
var FBL_LANG_DEFINED = FBL_LANG_DEFINED || 'en_US';
jQuery(document).ready(function () {
	facebook_like_set_form();
	facebook_like_render_button();
	// on location change
	jQuery('#button_location').change(function () {
		var location = jQuery("#button_location option:selected").val();
		if (location == "manual") {
			jQuery('#manual_instructions').show().animate({height:18}, 250);
		} else {
			jQuery('#manual_instructions').animate({height: 0}, 250, function() {
				jQuery('#manual_instructions').hide();
			});
		}
		if (location == 'left') {
			jQuery('#left_float_additional').find('div').show().animate({height:180}, 1000);
		} else {
			jQuery('#left_float_additional').find('div').animate({height: 0}, 1000, function() {
				jQuery('#left_float_additional').find('div').hide();
			});
		}
	});
	jQuery('#button_caption').change(function () { facebook_like_render_button(); });
	jQuery('#button_layout').change(function () { facebook_like_render_button(); });
	jQuery('#button_version').change(function () { facebook_like_render_button(); });
	jQuery('#color_scheme').change(function () { facebook_like_render_button(); });
	jQuery('#extra_style').change(function () { facebook_like_render_button(); });
	jQuery('#show_faces').change(function () { facebook_like_render_button(); });
	jQuery('#show_share').change(function () { facebook_like_render_button(); });
});
function facebook_like_render_xfbml_button () {
	var extra_html = '';
	if (jQuery("#show_faces ").is(':checked')) {
		extra_html += ' show_faces="true"';
	}
	if (jQuery("#show_share ").is(':checked')) {
		extra_html += ' send="true"';
	}
	if (jQuery("#button_caption").val() == 'recommend') {
		extra_html += ' action="recommend"';
	}
	if (jQuery("#color_scheme").val() == 'dark') {
		extra_html += ' colorscheme="dark"';
	}
	var layout = jQuery("#button_layout").val();
	if (layout != 'standard') {
		extra_html += ' layout="' + layout + '"';
	}
	jQuery("#preview_container").html('<fb:like' + extra_html + '></fb:like>');
	// change fb-code
	FB.XFBML.parse();
}
function facebook_like_render_iframe_button () {
	var url = 'http://www.facebook.com/plugins/like.php?href=http%3a%2f%2fjavascriptprog.hu%2f&width=450&height=80&locale=' + FBL_LANG_DEFINED;
	if (jQuery("#show_faces ").is(':checked')) {
		url += '&show_faces=true';
	}
	if (jQuery("#show_share ").is(':checked')) {
		url += '&send=true';
	}
	if (jQuery("#button_caption").val() == 'recommend') {
		url += '&action=recommend';
	}
	if (jQuery("#color_scheme").val() == 'dark') {
		url += '&colorscheme=dark';
	}
	var layout = jQuery("#button_layout").val();
	if (layout != 'standard') {
		url += '&layout=' + layout + '';
	}
	jQuery("#preview_container").html('<iframe src="' + url + '" scrolling="no" frameborder="0" style="border: none; overflow: hidden; width: 450px; height:80px;" allowTransparency="true"></iframe>');
}
function facebook_like_render_button () {
	if (jQuery("#button_version").val() == 'iframe') {
		facebook_like_render_iframe_button();
	} else {
		facebook_like_render_xfbml_button();
	}
}
function facebook_like_set_form () {
	jQuery("#button_caption").val(FBL.button_caption);
	jQuery("#button_layout").val(FBL.button_layout);
	jQuery("#button_location").val(FBL.button_location);
	jQuery("#button_version").val(FBL.button_version);
	jQuery("#color_scheme").val(FBL.color_scheme);
	jQuery("#extra_style").val(FBL.extra_style);
	jQuery("#left_space").val(FBL.left_space);
	jQuery("#position").val(FBL.position);
	jQuery("#top_space").val(FBL.top_space);

	if (FBL.script_load == 'true') {
		jQuery("#script_load").attr('checked', true);
	}
	if (FBL.show_faces == 'true') {
		jQuery("#show_faces").attr('checked', true);
	}
	if (FBL.show_share == 'true') {
		jQuery("#show_share").attr('checked', true);
	}
	if (FBL.show_on_home == 'true') {
		jQuery("#show_on_home").attr('checked', true);
	}
	if (FBL.show_on_single == 'true') {
		jQuery("#show_on_single").attr('checked', true);
	}
	if (FBL.extra_style == '') {
		jQuery("#extra_style").val('/* margin: 4px; */');
	} else {
		jQuery("#extra_style").val(FBL.extra_style);
	}
	if (FBL.left_space == '') {
		jQuery("#left_space").val('70px');
	} else {
		jQuery("#left_space").val(FBL.left_space);		
	}
	if (FBL.top_space == '') {
		jQuery("#top_space").val('60%');
	} else {
		jQuery("#top_space").val(FBL.top_space);
	}

	if (FBL.button_location != 'left') {
		jQuery('#left_float_additional').find('div').animate({height: 0}, 5, function() {
			jQuery('#left_float_additional').find('div').hide();
		});
	}
	if (FBL.button_location != 'manual') {
		jQuery('#manual_instructions').animate({height: 0}, 5, function() {
			jQuery('#manual_instructions').hide();
		});
	}
	jQuery("#button_location").val(FBL.button_location);
	jQuery("#position").val(FBL.position);
}
function facebook_like_fade_success () {
	jQuery('#setting-error-settings_updated').animate({opacity: 0, height: 0}, 'slow');
}
