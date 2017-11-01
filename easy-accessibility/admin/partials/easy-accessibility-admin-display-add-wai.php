<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin section where admin can set up WAI tags
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/admin/partials
 */
//This file should primarily consist of HTML with a little bit of PHP.

?> 
<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<p>Add accessibility tags</p>
	<div>
	<div class="tab">
		<a href="javascript:void(0)" class="tablinks" onclick="choose_edit(event, 'Posts')">Posts</a>
		<a href="javascript:void(0)" class="tablinks" onclick="choose_edit(event, 'Themes')">Themes</a>
		<a href="javascript:void(0)" class="tablinks" onclick="choose_edit(event, 'Plugins')">Plugins</a>
		<input name="submit_post" id="submit_post" class="button button-primary" value="Check WAI" type="submit" style="display:none">
		<input name="submit_theme" id="submit_theme" class="button button-primary" value="Check WAI" type="submit" style="display:none">
		<input name="submit_plugin" id="submit_plugin" class="button button-primary" value="Check WAI" type="submit" style="display:none">

	</div>
	<div id="Posts" class="tabcontent">
		<?php 	
		global $wp_post_types;
		$post_types =  array_keys( $wp_post_types );
		add_action('admin_init', function(){
			$post_types = get_post_types( array( 'public' => true ), 'names' ); 
			var_dump($post_types);
		});
		if ( $post_types ) { // If there are any custom public post types.
		?>
		<select name="post_types" id="post_type_list">
			<option selected="selected">Choose post type</option>
		<?php
	  
		foreach ( $post_types  as $post_type ) {
			?><option value="<?= $post_type ?>"><?= $post_type ?></option>
		<?php } ?>
		</select> 
		<?php } 
			$options = get_option($this->plugin_name);     
		?>
		<select name="post_types_post" id="post_type_list_posts" style="display:none;"></select>
		<input name="submit_post" id="submit_post" class="button button-primary" value="Check WAI" type="submit" style="display:none">
		<div class="check_code"></div>
		<div class="show_content">
			<form id="frm_edit" method="post" name="save_wai" action="options.php">
			<?php 
				settings_fields( $this->plugin_name );
				do_settings_sections( $this->plugin_name );
				$mycustomeditor = $options['mycustomeditor'];
			?>
				<fieldset>
					<div id="editHtml"></div>
				</fieldset>
					<?php
			submit_button(__('Save WAI', $this->plugin_name), 'primary','submit_wai', TRUE);
					?>
			</form>
		</div>
			<div id="show_page"></div>

		</div>
	</div>
	<div id="Themes" class="tabcontent">
		<div class="show_content">
			<!-- <iframe class="check_code" src="https://achecker.ca/checker/index.php#output_div"></iframe> -->
				<div class="check_code"></div>
			<div id="editthem"></div>
		</div>
	</div>

	<div id="Plugins" class="tabcontent">
	  <div class="show_content">
			<!-- <iframe class="check_code" src="https://achecker.ca/checker/index.php#output_div"></iframe> -->
				<div class="check_code"></div>
			<div id="editplugin"></div>
		</div>
	</div>

</div> <!--  .wrap -->
