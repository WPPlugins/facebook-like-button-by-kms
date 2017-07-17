<?php 
/*
Core logic to display social share icons at the required positions. 
*/
function facebook_like_share_init () {
	// DISABLED IN THE ADMIN PAGES
	if (is_admin()) {
		return;
	}
	$script_load = get_option('km_fbl_script_load');
	$plugin_dir = trailingslashit(plugins_url(dirname(plugin_basename(__FILE__))));
	wp_enqueue_script('facebook_like_script_loader', $plugin_dir . 'fbl_loader.js', false, false, ($script_load === "true"));
}    
function facebook_like_contents ($content) {
  global $post;
  if (get_post_status($post->ID) == 'publish') {
		$output = km_social_share();
	}
	$position = get_option('km_fbl_button_location');
  if ((is_single() && (get_option('km_fbl_show_on_single') == 'true'))
				|| (is_home() && (get_option('km_fbl_show_on_home') == 'true'))) {
		if ($position == 'top') {
			$content = $output . $content;
		}
		if ($position == 'bottom') {
			$content = $content . $output;
		}
		if ($position == 'left') {
			// only show with blog-post on single pages, else buttons get stacked over one-another
			if (is_home()) {
				add_action('wp_footer', 'km_fbl_home_share');
				return  $content;
			} else {
				return  $output . $content;
			}
		}
		if ($position == 'both') {
			$content = $output . $content . $output;
		}
	}
	return $content;
}
// Function to display just one button on homepage
function km_fbl_home_share () {
	$output = km_social_share(network_site_url());
	echo $output;
}
// Function to manually display on posts.
function km_fbl_share ($url = null) {
	echo km_social_share($url);
}
function km_fbl_render_iframe ($url) {
	global $locale;
	
	$button_caption  = get_option('km_fbl_button_caption');
	$button_layout 	 = get_option('km_fbl_button_layout');
	$color_scheme 	 = get_option('km_fbl_color_scheme');
	$show_faces 	   = get_option('km_fbl_show_faces');
	
	if ($show_faces == "true") {
		$url .= '&show_faces=true';
	}
	if ($button_caption == 'recommend') {
		$url .= '&action=recommend';
	}
	if ($color_scheme == 'dark') {
		$url .= '&colorscheme=dark';
	}
	if ($button_layout != 'standard') {
		$url .= '&layout=' . $button_layout . '';
	}
	$url .= '&locale=' . $locale . '';
	
	$url = '<iframe src="http://www.facebook.com/plugins/like.php?href=' . $url . '" scrolling="no" frameborder="0" allowTransparency="true" style="border: none; overflow: hidden; width: 450px; height: 26px"></iframe>';
	return $url;
}
function km_fbl_render_xfbml ($url) {
	global $locale;
	
	$button_caption  = get_option('km_fbl_button_caption');
	$button_layout 	 = get_option('km_fbl_button_layout');
	$button_location = get_option('km_fbl_button_location');
	$button_version  = get_option('km_fbl_button_version');
	$color_scheme 	 = get_option('km_fbl_color_scheme');
	$extra_style 	   = get_option('km_fbl_extra_style');
	$left_space 	   = get_option('km_fbl_left_space');
	$position 	     = get_option('km_fbl_position');
	$script_load 	   = get_option('km_fbl_script_load');
	$show_faces 	   = get_option('km_fbl_show_faces');
	$show_share 	   = get_option('km_fbl_show_share');
	$show_on_home 	 = get_option('km_fbl_show_on_home');
	$show_on_single  = get_option('km_fbl_show_on_single');
	$top_space 	     = get_option('km_fbl_top_space');
		
	if ($left_space == '') {
		$left_space = '70px';
	}
	if ($top_space == '') {
		$top_space = '60%';
	}
	$extra = '';
	if ($show_faces == "true") {
		$extra .= ' show_faces="true"';
	}
	if ($show_share == "true") {
		$extra .= ' send="true"';
	}
	if ($button_caption == 'recommend') {
		$extra .= ' action="recommend"';
	}
	if ($color_scheme == 'dark') {
		$extra .= ' colorscheme="dark"';
	}
	if ($button_layout != 'standard') {
		$extra .= ' layout="' . $button_layout . '"';
	}
	
	$url = '<script type="text/javascript">var FBL_LANG_DEFINED = "' . $locale . '";</script>'
				. '<fb:like href="' . $url . '"' . $extra . '></fb:like>';
	
	return $url;
}
function km_social_share($url = null) {
	if ($url == null) $url = get_permalink();
	
	//GET ARRAY OF STORED VALUES
	$button_location = get_option('km_fbl_button_location');
	$button_version  = get_option('km_fbl_button_version');
	$extra_style 	   = get_option('km_fbl_extra_style');
	$left_space 	   = get_option('km_fbl_left_space');
	$position 	     = get_option('km_fbl_position');
	$top_space 	     = get_option('km_fbl_top_space');
	
	$output = '';
	
	if ($button_version == "iframe") {
		$fbl = km_fbl_render_iframe($url);
	} else {
		$fbl = km_fbl_render_xfbml($url);
	}
	if ($button_location == 'left'){
		$output .= '<div class="fblikebutton_button" style="' . $extra_style . '; position: ' . $position . '; top: ' . $top_space . '; left: ' . $left_space . ';">' . $fbl . '</div>';
	}
	if (($button_location == 'top')
			|| ($button_location == 'bottom')
			|| ($button_location == 'manual')
			|| ($button_location == 'both')) {
		$output .= '<div class="fblikebutton_button" style="' . $extra_style . '">' . $fbl . '</div>';
	}
	return $output;
}
