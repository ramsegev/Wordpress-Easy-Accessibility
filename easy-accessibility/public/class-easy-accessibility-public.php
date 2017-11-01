<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/public
 * @author     Ram Segev <ramsegev@gmail.com>
 */
class Easy_Accessibility_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	    $this->easy_accessibility_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Accessibility_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Accessibility_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-accessibility-public.css', array(), $this->version, 'all' );
		//Font Awesome CDN
		wp_enqueue_style('font-awesome', 'https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css');
		wp_enqueue_style('jquery-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css');
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Easy_Accessibility_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Easy_Accessibility_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-accessibility-public.js', array( 'jquery' ), $this->version, false );
		wp_deregister_script('jquery');
		wp_deregister_script('jquery-ui');
        wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js', false, '3.1.0');
        wp_register_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js', false, '1.11.4');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui');
		
			   include('partials/easy-accessibility-public-display.php');
	}
	
	
	
    
	
    public function public_display_accessibility_menu() {
	   
	  // include('partials/easy-accessibility-public-display.php');   
	   
	}

}
