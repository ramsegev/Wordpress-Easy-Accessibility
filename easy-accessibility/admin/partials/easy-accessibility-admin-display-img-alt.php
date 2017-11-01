<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin section where admin can set up images alt
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/admin/partials
 */
?> <div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<p>Add ALT to images </p>
	<div>
	<?php	// Get All Post IDs
	$post_image_query = new WP_Query( 
		array( 
			'post_type' => 'any', 
			'posts_per_page' => -1,
			'fields' => 'ids',			//'post_status' => 'publish'
		) 
	);	$selected_posts = $post_image_query->posts;
	$the_attachments = get_posts(array(
		'post_parent__in' => $selected_posts,
		'numberposts' => -1,
		'post_type' => 'attachment'
	));
	$attr = '';
	$options = get_option($this->plugin_name);     
?>
		<form id="frm_alt" method="post" name="save_alt" action="options.php">
<?php		if ($the_attachments) {			//$index = 0;
			settings_fields( $this->plugin_name );
			do_settings_sections( $this->plugin_name );
			foreach ( $the_attachments as $my_attachment ) {					$ea_edit_alt = $options['ea_edit_alt_'.$my_attachment->ID];
				echo '<div class="altEditBlock">';
				echo wp_get_attachment_image($my_attachment->ID);
				echo '<div><p>';
				$title = get_the_title($my_attachment->ID);
				echo $title;
				echo '</p><p>';
				$attr = get_post_meta($my_attachment->ID, '_wp_attachment_image_alt', true);
				?>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e('Add/Edit image alt', $this->plugin_name);?></span></legend>
					<label for="<?php echo $this->plugin_name;?>_ea_edit_alt_<?php echo $my_attachment->ID ?>"></label>
					<input type="text" id="<?php echo $this->plugin_name;?>-ea_edit_alt_<?php echo $my_attachment->ID ?>" name="<?php echo $this->plugin_name?>[ea_edit_alt_<?php echo $my_attachment->ID ?>]"  value="<?php if(!empty($attr)) echo $attr; ?>"/>
									</fieldset>
			<?php
				echo '</p></div>';
				echo '</div>';
				}
			}
			submit_button(__('Save Alts', $this->plugin_name), 'primary','submit_alt', TRUE);
 ?>		</form>	</div></div> <!--  .wrap -->
