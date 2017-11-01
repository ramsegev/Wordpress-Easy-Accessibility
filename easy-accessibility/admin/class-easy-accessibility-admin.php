<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/admin
 */

class Easy_Accessibility_Admin {

	/**
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->easy_accessibility_options = get_option($this->plugin_name);

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-accessibility-admin.css', array(), $this->version, 'all' );
		if ( 'settings_page_easy-accessibility' == get_current_screen() -> id ) {
         }
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/easy-accessibility-admin.js', array( 'jquery' ), $this->version, false );
		$script_params = array(
		   'post_obj' => 'post',
		   'plugin_name' => $this->plugin_name,
		   'site_url' => site_url()
        );
        wp_localize_script($this->plugin_name, 'scriptParams', $script_params );
	}



	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	 
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 */
		add_menu_page( 'Easy Accessibility  Options  Setup', 'Easy Accessibility', 'Menu Display', $this->plugin_name, array($this, 'display_plugin_setup_page_add_remove'),'dashicons-admin-generic',10);
        add_submenu_page( $this->plugin_name, 'Easy Accessibility Menu Display', 'Menu Display', 'manage_options', $this->plugin_name.'_add_remove', array($this, 'display_plugin_setup_page_add_remove') );
        add_submenu_page( $this->plugin_name, 'Easy Accessibility Image ALT', 'Images ALTs', 'manage_options', $this->plugin_name.'_img_alt', array($this, 'display_plugin_setup_page_img_alt') );
        add_submenu_page( $this->plugin_name, 'Easy Accessibility Add WAI', 'Add WAI', 'manage_options', $this->plugin_name.'_add_wai', array($this, 'display_plugin_setup_page_add_wai') );
	}
 
	 /**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	 
	public function add_action_links( $links ) {
	   $settings_link = array(
		'<a href="' . admin_url( 'admin.php?page='.$this->plugin_name.'_add_remove') . '">' . __('Settings', $this->plugin_name) . '</a>',
	   );
	   return array_merge(  $settings_link, $links );

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	 
    public function display_plugin_setup_page_add_remove(){
        include_once( 'partials/easy-accessibility-admin-display-add-remvoe.php' );
    }
	public function display_plugin_setup_page_img_alt(){
        include_once( 'partials/easy-accessibility-admin-display-img-alt.php' );
    }
	public function display_plugin_setup_page_add_wai(){
        include_once( 'partials/easy-accessibility-admin-display-add-wai.php' );
    }
	public function options_update() {
		register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}
	
	
	
	public function validate($input) {
    // All checkboxes inputs        
		$valid = array();
        $options = get_option($this->plugin_name);
		$post_image_query = new WP_Query( 
		array( 
			'post_type' => 'any', 
			'posts_per_page' => -1,
			'fields' => 'ids'
		) 
		);
		$selected_posts = $post_image_query->posts;
		$option_name = '_wp_attachment_image_alt' ;
		$the_attachments = get_posts(array(
			'post_parent__in' => $selected_posts,
			'numberposts' => -1,
			'post_type' => 'attachment'
		));
		foreach ( $the_attachments as $my_attachment ) {	
			if(isset($input['ea_edit_alt_'.$my_attachment->ID])){
				if(!empty($input['ea_edit_alt_'.$my_attachment->ID])){
					$valid['ea_edit_alt_'.$my_attachment->ID] = sanitize_text_field($input['ea_edit_alt_'.$my_attachment->ID]);
				}else{
					$valid['ea_edit_alt_'.$my_attachment->ID] = '';
				}
			}
			else{
					$valid['ea_edit_alt_'.$my_attachment->ID] = $options['ea_edit_alt_'.$my_attachment->ID];
			}
			update_post_meta( $my_attachment->ID,$option_name, $valid['ea_edit_alt_'.$my_attachment->ID]);
		}
		if(isset($input['ea_fontsize'])){
			$valid['ea_fontsize'] = (!empty($input['ea_fontsize'])) ? 1 : null;
        }else{
                $valid['ea_fontsize'] = $options['ea_fontsize'];
        }
		if(isset($input['ea_change_contrast'])){
			$valid['ea_change_contrast'] = (!empty($input['ea_change_contrast'])) ? 1 : null;
        }else{
                $valid['ea_change_contrast'] = $options['ea_change_contrast'];
        }
		if(isset($input['ea_mouse_size'])){
            $valid['ea_mouse_size'] = (!empty($input['ea_mouse_size'])) ? 1 : 0;
        }else{
                $valid['ea_mouse_size'] = $options['ea_mouse_size'];
        }
		if(isset($input['ea_link_color'])){
            $valid['ea_link_color'] = (!empty($input['ea_link_color'])) ? 1 : 0;
        }else{
                $valid['ea_link_color'] = $options['ea_link_color'];
        }
		if(isset($input['ea_readable_font'])){
            $valid['ea_readable_font'] = (!empty($input['ea_readable_font'])) ? 1 : 0;
        }else{
                $valid['ea_readable_font'] = $options['ea_readable_font'];
        }
		if(isset($input['ea_animation'])){
            $valid['ea_animation'] = (!empty($input['ea_animation'])) ? 1 : 0;
        }else{
                $valid['ea_animation'] = $options['ea_animation'];
        }
		if(isset($input['ea_img_desc'])){
            $valid['ea_img_desc'] = (!empty($input['ea_img_desc'])) ? 1 : 0;
        }else{
                $valid['ea_img_desc'] = $options['ea_img_desc'];
        }
		
		if(isset($input['mycustomeditor'])){
			if(!empty($input['mycustomeditor'])){
				$valid['mycustomeditor'] = ($input['mycustomeditor']);
			}else{
				$valid['mycustomeditor'] = '';
			}
		}
		else{
				$valid['mycustomeditor'] = $options['mycustomeditor'];
		}
		
			$post_id = get_option('mycustomeditor');
			$my_post = array(
			'ID'           => $post_id,
			'post_content' =>$valid['mycustomeditor'],
			);
	 
			// Update the post into the database
			wp_update_post( $my_post );
		
		return $valid;
 }




    /**
     * Utility functions
     *
     * @since    1.0.0
     */

     private function sass_darken($hex, $percent) {
         preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors);
         str_replace('%', '', $percent);
         $color = "#";
         for($i = 1; $i <= 3; $i++) {
             $primary_colors[$i] = hexdec($primary_colors[$i]);
             $primary_colors[$i] = round($primary_colors[$i] * (100-($percent*2))/100);
             $color .= str_pad(dechex($primary_colors[$i]), 2, '0', STR_PAD_LEFT);
         }
 
         return $color;
     }
 
     private function sass_lighten($hex, $percent) {
         preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors);
         str_replace('%', '', $percent);
         $color = "#";
         for($i = 1; $i <= 3; $i++) {
             $primary_colors[$i] = hexdec($primary_colors[$i]);
             $primary_colors[$i] = round($primary_colors[$i] * (100+($percent*2))/100);
             $color .= str_pad(dechex($primary_colors[$i]), 2, '0', STR_PAD_LEFT);
         }

         return $color;
     }
	 	public function get_post_list(){
		$get_post_type = '';
		if(isset($_GET['the_post_type'])){
			$get_post_type = sanitize_text_field($_GET['the_post_type']);
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_type' => $get_post_type,
				'post_status' => 'publish',
				'posts_per_page' => -1,
			); 
			$myposts = get_posts( $args );
			//$print_select =  "<select name=post_types_post id=post_type_list_posts>";
			$print_option = "<option selected=selected>Choose post</option>";
			foreach($myposts as $mypost) {
				if(empty($title)){
					$title = 'no title';
				}
				else{
					$title = $mypost->post_title;
				}
				//if(is_object($page)){
					$print_option = $print_option . "<option value=". $mypost->ID .">". $title ."</option>";
				//}
			}
			//$print_select = $print_select . $print_option . "</select>";
			//echo $print_option;
			
			wp_die($print_option);
		}
	 }
	 
	public function get_the_content_by_id() {
		//validate_content_by_id();
		  $get_post_id = '';
		if(isset($_GET['post_id'])){
			$get_post_id = sanitize_text_field($_GET['post_id']);
			$args = array(
				'sort_order' => 'asc',
				'sort_column' => 'post_title',
				'post_id' => $get_post_id,
				'post_status' => 'publish'
			); 
			$response = get_post( $get_post_id );
			$content = $response->post_content;
			$editor_id = $this->plugin_name.'-mycustomeditor';
			$editor_name = $this->plugin_name.'[mycustomeditor]';
			$settings = array( 
				'quicktags' => array( 'buttons' => 'strong,em,del,ul,ol,li,close' ), // note that spaces in this list seem to cause an issue
				'textarea_name' => $editor_name,
				'tinymce' => false,
				//'teeny'	=>true,
				'media_buttons' => false,
				);
			$data = array(
				'post_type'     => 'easy_post_type',
				'post_content'    => sanitize_text_field($content),
				'post_status'   => 'publish',
				
			);
			$options = get_option($this->plugin_name); 
			$old_id = get_option("easy_new_id");
			wp_delete_post($old_id , true );
			$result = wp_insert_post( $data );
			update_option( "easy_new_id", $result."");
			update_option( "mycustomeditor", $get_post_id."");
			$editor_content = wp_editor( $content, $editor_id, $settings );
			echo $editor_content;
			wp_die();

		}	
	} 

	 public function validate_wai(){
		$uri = '';
		$content = '';
		if(isset($_POST['content'])){
			$content = sanitize_text_field($_POST['content']);
			$data = array(
				'post_type'     => 'easy_post_type',
				'post_content'    => $content,
				'post_status'   => 'publish',
			);
			$result = wp_insert_post( $data );
			update_option( "easy_new_id", $result."");
		}
		if(isset($_POST['uri'])){
			$new_id = get_option("easy_new_id");
			$uri = sanitize_text_field($_POST['uri']). $new_id;
			$id = "1557c063261651d3a98018fb8c033ae8a5f34e25";//"07b83e75076b6ba7784c288e5cd5759c15e7ec6a";
			$output = "html";
			$guide = "STANCA,wcag-2.0-l2";//"STANCA,WCAG2-AA";
			$offset = "0";
			$checklink = "uri=".$uri."&id=".$id."&output=".$output."&guide=".$guide."&offset=".$offset."&errorMsg=true";
			/* $checklink = array(
				"uri"=> $uri,
				"id"=>$id,
				"output"=>$output,
				"guide"=>$guide,
				"offset"=>$offset,
				"errorMsg"=>true,
			); */
			
			try {
				$ch = curl_init();
				if (FALSE === $ch){
					throw new Exception('failed to initialize');
					echo "ch";
				}
				$options = array(
					CURLOPT_URL            => "https://achecker.ts.vcu.edu/checkacc.php", //"https://achecker.ca/checkacc.php",
					CURLOPT_POSTFIELDS	   => $checklink,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HEADER         => false,
					//CURLOPT_FOLLOWLOCATION => true,
					//CURLOPT_ENCODING       => "",
					//CURLOPT_AUTOREFERER    => true,
					//CURLOPT_POST		   => true,
					CURLOPT_ENCODING       => "gzip",
					CURLOPT_SSL_VERIFYHOST => false,
					CURLOPT_SSL_VERIFYPEER => false,
					/* CURLOPT_CONNECTTIMEOUT => 120,
					CURLOPT_TIMEOUT        => 120,
					CURLOPT_MAXREDIRS      => 10, */
				);
				curl_setopt_array( $ch, $options );
				
				$response = curl_exec( $ch );
				curl_close($ch);
				wp_die($response);
				//$xml = new SimpleXMLElement($response);
				//header('Content-type: text/xml');
				//echo $xml->asXML();
				//$xml = simplexml_load_file($response);
				//$json = json_encode($xml);
				//$array = json_decode($json,TRUE);
				
				//$response = trim(str_replace('"', "'", $response));
								//$response = html_entity_decode($response);
								
				//$response = htmlspecialchars($response, ENT_XML1, 'ISO-8859-1', true);
							//$response = trim($response);
								//echo var_export($response, true);
								
				// $response = trim(str_replace('"', "", $response));
				 //$response = $response . ";";
				 //$response = preg_replace('#&(?=[a-z_0-9]+=)#', '&amp;', $response);
				/* $response = trim(str_replace('\n', "", $response));
				$response = trim(str_replace('\\', "", $response));	 */		
				//$parse_response = simplexml_load_string($response, 'SimpleXMLElement', LIBXML_NOCDATA);
				//$json = json_encode($response, JSON_PRETTY_PRINT);
				//$json = json_encode($response, JSON_HEX_QUOT | JSON_HEX_TAG);
				//$json = json_decode(parse_response);
				//$json = preg_replace("/\\\\u([0-9a-f]{3,4})/i", "&#x\\1;", $json);
				//$array = json_decode($json);
				//var_dump($json);
				//$xml = new SimpleXMLElement((string)$array);
				//$parse_response = simplexml_load_string($response);
				//$json = trim(str_replace('"', "", $json));
				//$json = trim(str_replace('\n', "", $json));
				//$json = trim(str_replace('\\', "", $json));
/* $response = new SimpleXMLElement($response);

//echo $response->getName() . "\n";

foreach ($response->children() as $child)
{
    echo $child->getName() . "\n";
} */
/* $context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$xml = file_get_contents($ch, false, $context);
$xml = simplexml_load_string($xml); */
 libxml_use_internal_errors(true);
// $sxe = new SimpleXMLElement(simplexml_load_string(file_get_contents($response)));
$xpa = file_get_contents('https://achecker.ts.vcu.edu/checkacc.php?'.$checklink);
$sxe = simplexml_load_string($response);
//$sxe = simplexml_load_string($response);
if ($sxe === false) {
    echo "Failed loading XML\n";
    foreach(libxml_get_errors() as $error) {
        echo "\t", $error->message;
    }
} 
$json = json_encode($sxe);
$json = trim(str_replace('"', "", $json));
$json = trim(str_replace('\n', "", $json));
$json = trim(str_replace('\\', "", $json));
$array = json_decode($json);
 /* $xmlDoc = new DOMDocument();
$xmlDoc->load($sxe);
echo $xmlDoc->saveXML();
$x = $xmlDoc->documentElement;
foreach ($x->childNodes AS $item) {
  echo $item->nodeName . " = " . $item->nodeValue . "<br>";
} */

		echo("No of  known Problems: " . $sxe->summary->NumOfErrors . PHP_EOL); 
		echo("No of  known Problems1: " . $json[0]->NumOfErrors . PHP_EOL); 
		echo("NumOfLikelyProblems: " . $sxe->summary->NumOfLikelyProblems . PHP_EOL); 
		echo("NumOfPotentialProblems: " . $sxe->summary->NumOfPotentialProblems . PHP_EOL);
 foreach ($sxe->results->result AS $item)
		{
			//fputs($f, "Type: " .$item->resultType . PHP_EOL);
			//fputs($f, "Error msg: <font size=2 color=	#ADFF2F>" .$item->errorMsg ."</font><br/>" . PHP_EOL);
			//	if (strcmp($item->resultType ,"Potential Problem")==0)
			//{
				$sequenceid=explode("_", $item->errorSourceCode);
				//$checkid[$i]=$sequenceid[2];
				//echo $checkid[$i] . "<br>";
				//fputs($f, "Checkid " . $sequenceid[2]. PHP_EOL);
				echo "<font size=3 color=red>Checkid: ". $checkid[$i] ."</font> <br/> " ;
				echo "<font size=2 color=green>line,col,checkid: ". $item->errorSourceCode."</font> <br/><br/>";//sequenceID 	A child of result. The unique sequence ID identifying each error/problem. This ID is used to pinpoint each error/problem in make/reverse decision request.
				//echo "<font size=1 color=green>line,col,checkid: ". $item->errorSourceCode."</font> <br/><br/>";//sequenceID 	A child of result. The unique sequence ID identifying each error/problem. This ID is used to pinpoint each error/problem in make/reverse decision request.
				$i++;
			//} 
		}
 
				//wp_die(htmlspecialchars($sxe->asXML()) );
				wp_die($json);

							//echo curl_error($ch);
				/* $responsearray = array ('response' =>$response, 'editor_content' =>null);
				
				$responseJson = json_encode($responsearray); */
				
				/* if (FALSE === $response){
					throw new Exception(curl_error($ch), curl_errno($ch));
					echo "response";
				}
				$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

				if ( $httpCode != 200 ){
					echo "Return code is {$httpCode} \n".curl_error($ch);
					curl_close($ch);

				} else {
					curl_close($ch); */
					//echo $response; //htmlspecialchars($responsearray);
					//$json = html_entity_decode($json, null, 'UTF-8');
						//	wp_die($json);

				//}
				//curl_close($ch);
				
				//echo $response;
			} catch(Exception $e) {
				//echo $editor_content;
				trigger_error(sprintf(
				'Curl failed with error #%d: %s',
				$e->getCode(), $e->getMessage()),
				E_USER_ERROR);

			}
		wp_die();
		}
	} 

	
	public function easy_custom_post_type()
	{
		register_post_type('easy_post_type',
						   [
							   'labels'      => [
								   'name'          => __('easy_types'),
								   'singular_name' => __('easy_type'),
							   ],
								'public'      => true,
								'has_archive' => false,
							   	'supports' => array(),
								'taxonomies' => array(),	
								'exclude_from_search' => true,
								'capability_type' => 'post',
								//'query_var' => true,
								'slug' => 'easy_post_type'
						   ]
		);
	}
	public function remove_post_type_menu(){
			remove_menu_page( 'edit.php?post_type=easy_post_type' );
	}
	public function easy_post_template( $template ){
		//global $wp_query, $post;
		flush_rewrite_rules( true );
		$plugindir = dirname(__FILE__);
		echo "<script>console.log('sda ".$plugindir."')</script>";

		$post_type = get_post_type();//get_query_var('post_type');
		echo "<script>console.log('sda ". get_post_type() ."')</script>";

		if( $post_type == 'easy_post_type' ){
			return $plugindir . '/partials/easy-accessibility-wai-html.php';
		}

		return $template;  
	}
	
}
