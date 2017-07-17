<?php
/*
The main admin page for this plugin. The logic for different user input and form submittion is written here. 
*/
function facebook_like_admin_menu () {
	$plugin_page = add_options_page(__('Facebook like settings', 'facebook_like_button_by_kms'), __('Facebook like', 'facebook_like_button_by_kms'), 'administrator',
		'facebook-like-share-button', 'facebook_like_admin_page');
	add_action( "admin_print_scripts-$plugin_page", 'facebook_like_admin_head' );
}
function facebook_like_admin_head () {
	add_action('wp_print_scripts', 'enqueue_km_fbl_scripts');
	$plugin_dir = trailingslashit(plugins_url(dirname(plugin_basename(__FILE__))));
	wp_enqueue_script('loadjs', $plugin_dir . 'fbl_admin.js');
	echo "<link rel='stylesheet' href='" . $plugin_dir . "fbl_admin.css' type='text/css' />\n";
}
function facebook_like_admin_page () {
	if (! current_user_can('manage_options'))  {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	$update = false;
	if (isset($_POST['km_fbl_submit'])
			&& $_POST['km_fbl_submit'] === "true") {
		if ($_POST['script_load'] === 'true') {
			$script_load = 'true';
		} else {
			$script_load = 'false';
		}
		if ($_POST['show_faces'] === 'true') {
			$show_faces = 'true';
		} else {
			$show_faces = 'false';
		}
		if ($_POST['show_share'] === 'true') {
			$show_share = 'true';
		} else {
			$show_share = 'false';
		}
		if ($_POST['show_on_home'] === 'true') {
			$show_on_home = 'true';
		} else {
			$show_on_home = 'false';
		}
		if ($_POST['show_on_single'] === 'true') {
			$show_on_single = 'true';
		} else {
			$show_on_single = 'false';
		}
		update_option('km_fbl_button_caption', $_POST['button_caption']);
		update_option('km_fbl_button_layout', $_POST['button_layout']);
		update_option('km_fbl_button_location', $_POST['button_location']);
		update_option('km_fbl_button_version', $_POST['button_version']);
		update_option('km_fbl_color_scheme', $_POST['color_scheme']);
		update_option('km_fbl_extra_style', $_POST['extra_style']);
		update_option('km_fbl_left_space', $_POST['left_space']);
		update_option('km_fbl_position', $_POST['position']);
		update_option('km_fbl_script_load', $script_load);
		update_option('km_fbl_show_faces', $show_faces);
		update_option('km_fbl_show_share', $show_share);
		update_option('km_fbl_show_on_home', $show_on_home);
		update_option('km_fbl_show_on_single', $show_on_single);
		update_option('km_fbl_top_space', $_POST['top_space']);
		$update = true;
	}
	wp_enqueue_script('jquery'); 
?>
<div class="wrap">
<div class="icon32" id="icon-options-general"><br></div>
<h2><?php _e('Facebook like (recommend) settings', 'facebook_like_button_by_kms'); ?></h2>
<?php if ($update) { ?>
	<div id="setting-error-settings_updated" class="updated settings-error"><p><strong><?php _e('Settings saved.'); ?></strong></p></div>
<?php } ?>
	<div id="preview_wrapper">
		<div id="preview_area">
			<div id="preview_container"><fb:like></fb:like></div>
		</div>
	</div>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<input type="hidden" name="km_fbl_submit" value="true"> 
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="posts_per_page"><?php _e("The button's", 'facebook_like_button_by_kms'); ?></label>
				</th>
				<td>
					<p>
						<label>
							... <?php _e('version', 'facebook_like_button_by_kms'); ?>:
							<select name="button_version" id="button_version">
								<option value="iframe"><?php _e('iframe', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="xfbml"><?php _e('xfbml', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							... <?php _e('layout', 'facebook_like_button_by_kms'); ?>:
							<select name="button_layout" id="button_layout">
								<option value="standard"><?php _e('standard', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="box_count"><?php _e('box', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="button_count"><?php _e('button', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							... <?php _e('location', 'facebook_like_button_by_kms'); ?>:
							<select name="button_location" id="button_location">
								<option value="top"><?php _e('above the post', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="bottom"><?php _e('below the post', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="both"><?php _e('above AND below', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="left"><?php _e('floating on left', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="manual"><?php _e('placed manually', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							... <?php _e('color scheme', 'facebook_like_button_by_kms'); ?>:
							<select name="color_scheme" id="color_scheme">
								<option value="light"><?php _e('light', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="dark"><?php _e('dark', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							... <?php _e('caption', 'facebook_like_button_by_kms'); ?>:
							<select name="button_caption" id="button_caption">
								<option value="like"><?php _e('like', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="recommend"><?php _e('recommend', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
					<p>
						<label>
							... <?php _e('styling', 'facebook_like_button_by_kms'); ?>:
							<input type="text" name="extra_style" id="extra_style" size="50" />
						</label>
					</p>
					<p>
						<ul>
							<li><em><?php _e('If you select left floating location, please revise additional information displayed below.', 'facebook_like_button_by_kms'); ?></em></li>
							<li id="manual_instructions"><em><?php echo sprintf(__("Insert the %s code into your theme where you'd like to see the button", 'facebook_like_button_by_kms'), highlight_string('<?php km_fbl_share([url_to_link_to]); ?>', true)); ?></em></li>
						</ul>
					</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="posts_per_page"><?php _e('Display', 'facebook_like_button_by_kms'); ?></label>
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="show_faces" id="show_faces" value="true" />
							<?php _e('with faces', 'facebook_like_button_by_kms'); ?>
						</label>
					</p>
					<p>
						<label>
							<input type="checkbox" name="show_share" id="show_share" value="true" />
							<?php _e('also "Share" option', 'facebook_like_button_by_kms'); ?> <em>(<?php _e('has only meaning when XFBML version is used', 'facebook_like_button_by_kms'); ?>)</em>
						</label>
					</p>
					<p>
						<label>
							<input type="checkbox" name="show_on_home" id="show_on_home" value="true" />
							<?php _e('on first page', 'facebook_like_button_by_kms'); ?>
						</label>
					</p>
					<p>
						<label>
							<input type="checkbox" name="show_on_single" id="show_on_single" value="true" />
							<?php _e('besides posts', 'facebook_like_button_by_kms'); ?>
						</label>
					</p>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="posts_per_page"><?php _e('JavaScript SEO', 'facebook_like_button_by_kms'); ?></label>
				</th>
				<td>
					<p>
						<label>
							<input type="checkbox" name="script_load" id="script_load" value="true" />
							<?php _e('at the bottom of the page in the footer section', 'facebook_like_button_by_kms'); ?>
						</label>
					</p>
				</td>
			</tr>
			<tr valign="top" id="left_float_additional">
				<th scope="row"><div>
					<label for="posts_per_page"><?php _e("Floating button's", 'facebook_like_button_by_kms'); ?></label>
				</div></th>
				<td><div>
					<p>
						<label>
							... <?php _e('spacing on top', 'facebook_like_button_by_kms'); ?>:
							<input type="text" name="top_space" id="top_space" size="10" />
						</label>
					</p>
					<p>
						<ul>
							<li><em><?php echo sprintf(__("The Button's spacing from top. For example: %s", 'facebook_like_button_by_kms'), highlight_string('60%', true)); ?></em></li>
						</ul>
					</p>
					<p>
						<label>
							... <?php _e('spacing left', 'facebook_like_button_by_kms'); ?>:
							<input type="text" name="left_space" id="left_space" size="10" />
						</label>
					</p>
					<p>
						<ul>
							<li><em><?php echo sprintf(__("The Button's spacing from the left side. For example: %s", 'facebook_like_button_by_kms'), highlight_string('70px', true)); ?></em></li>
						</ul>
					</p>
					<p>
						<label>
							... <?php _e('position', 'facebook_like_button_by_kms'); ?>:
							<select name="position" id="position">
								<option value="fixed"><?php _e('Fixed', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
								<option value="absolute"><?php _e('Absolut', 'facebook_like_button_by_kms'); ?>&nbsp;</option>
							</select>
						</label>
					</p>
				</div></td>
			</tr>
		</table>
		<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>		
</div>

<script>
	jQuery(document).ready(function () {
		<?php if ($update) { ?>	setTimeout(facebook_like_fade_success, 5000);<?php } ?>
	});
	var FBL = {};
	FBL.button_caption 	= '<?php echo get_option('km_fbl_button_caption'); ?>';
	FBL.button_layout 	= '<?php echo get_option('km_fbl_button_layout'); ?>';
	FBL.button_location 	= '<?php echo get_option('km_fbl_button_location'); ?>';
	FBL.button_version 	= '<?php echo get_option('km_fbl_button_version'); ?>';
	FBL.color_scheme 	= '<?php echo get_option('km_fbl_color_scheme'); ?>';
	FBL.extra_style 	= '<?php echo get_option('km_fbl_extra_style'); ?>';
	FBL.left_space 	= '<?php echo get_option('km_fbl_left_space'); ?>';
	FBL.position 	= '<?php echo get_option('km_fbl_position'); ?>';
	FBL.script_load 	= '<?php echo get_option('km_fbl_script_load'); ?>';
	FBL.show_faces 	= '<?php echo get_option('km_fbl_show_faces'); ?>';
	FBL.show_share 	= '<?php echo get_option('km_fbl_show_share'); ?>';
	FBL.show_on_home 	= '<?php echo get_option('km_fbl_show_on_home'); ?>';
	FBL.show_on_single 	= '<?php echo get_option('km_fbl_show_on_single'); ?>';
	FBL.top_space 	= '<?php echo get_option('km_fbl_top_space'); ?>';
</script>
<?php }
