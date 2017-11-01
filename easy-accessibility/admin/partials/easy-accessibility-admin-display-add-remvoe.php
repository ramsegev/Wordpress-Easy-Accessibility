<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin section where admin can set up the option to add or remove option from the font-end
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/admin/partials
 */
//This file should primarily consist of HTML with a little bit of PHP.
?>


<?php
    //Grab all options

        $options = get_option($this->plugin_name);

        $ea_fontsize = $options['ea_fontsize'];
        $ea_change_contrast = $options['ea_change_contrast'];
        $ea_mouse_size = $options['ea_mouse_size'];
        $ea_link_color = $options['ea_link_color'];
        $ea_readable_font = $options['ea_readable_font'];
		$ea_animation = $options['ea_animation'];
        $ea_img_desc = $options['ea_img_desc'];

        
    ?>

<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
	<p>Choose which option do you want to show in the frontend for the user: </p>
	<form method="post" name="cleanup_options" action="options.php">

    <?php
        settings_fields( $this->plugin_name );
        do_settings_sections( $this->plugin_name );
    ?>
		<fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Change font size option', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>-abfont-size">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>-abfont-size" name="<?php echo $this->plugin_name;?>[ea_fontsize]" value="1" <?php checked( $ea_fontsize, 1 ); ?> />
	            <span><?php esc_attr_e( 'Change font Size option', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>

	    <fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Change Contrast', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_change_contrast">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_change_contrast" name="<?php echo $this->plugin_name;?>[ea_change_contrast]" value="1" <?php checked( $ea_change_contrast, 1 ); ?> />
	            <span><?php esc_attr_e( 'Change contrast', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>

	    <fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Change Mouse size', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_mouse_size">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_mouse_size" name="<?php echo $this->plugin_name;?>[ea_mouse_size]" value="1" <?php checked( $ea_mouse_size, 1 ); ?> />
	            <span><?php esc_attr_e( 'Change Mouse size', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>

	    <fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Change link color', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_link_color">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_link_color" name="<?php echo $this->plugin_name;?>[ea_link_color]" value="1" <?php checked( $ea_link_color, 1 ); ?> />
	            <span><?php esc_attr_e( 'Change link color', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>

	    <fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Change font family', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_readable_font">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_readable_font" name="<?php echo $this->plugin_name;?>[ea_readable_font]" value="1" <?php checked( $ea_readable_font, 1 ); ?> />
	            <span><?php esc_attr_e( 'Change font family', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>
		
		<fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Stop animation', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_animation">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_animation" name="<?php echo $this->plugin_name;?>[ea_animation]" value="1" <?php checked( $ea_animation, 1 ); ?> />
	            <span><?php esc_attr_e( 'Stop animation', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>
		
		<fieldset>
	        <legend class="screen-reader-text"><span><?php _e('Show image description', $this->plugin_name);?></span></legend>
	        <label for="<?php echo $this->plugin_name;?>_ea_img_desc">
	            <input type="checkbox" id="<?php echo $this->plugin_name;?>_ea_img_desc" name="<?php echo $this->plugin_name;?>[ea_img_desc]" value="1" <?php checked( $ea_img_desc, 1 ); ?> />
	            <span><?php esc_attr_e( 'Show image description', $this->plugin_name ); ?></span>
	        </label>
	    </fieldset>
			
		<?php submit_button(__('Save Menu', $this->plugin_name), 'primary','submit_menu', TRUE); ?>
	</form>
</div> <!--  .wrap -->
