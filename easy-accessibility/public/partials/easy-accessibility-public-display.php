<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://webcontrol.co.il
 * @since      1.0.0
 *
 * @package    Easy_Accessibility
 * @subpackage Easy_Accessibility/public/partials
 <!-- This file should primarily consist of HTML with a little bit of PHP. -->
 */
?><?php	$options = get_option( 'easy-accessibility' );?>

<div id="accessibility_menu" class="fa fa-universal-access fa-5x">
	<nav id="accessibility_menu_content">
		<p class = "title">Easy Accessibility</p>
<?php	if (isset($options['ea_fontsize'])){ ?>
		<p class = "title">Font size</p>
		<div class="lineWrap">
			 <ul id="fontSize">
			 	<li id="font_size_slider"><span id="showperc"></span></li>
				<li id="btn-decrease" class="tree_column right">A-</li>
				<li id="btn-orig" class="tree_column">A</li>
				<li id="btn-increase" class="tree_column left">A+</li>
			</ul>
		</div>
<?php } ?>
<?php	if (isset($options['ea_change_contrast'])){ ?>
		<p class = "title">Contrast</p>
		<div class="lineWrap">
			<ul id="contrast">
				<li id="dark_contrast" class="tree_column right">Dark</li>
				<li id="btn_orig_contrast" class="tree_column">Normal</li>
				<li id="bright_contrast" class="tree_column left">Bright</li>
			</ul>
		</div>
<?php } ?>
<?php	if (isset($options['ea_mouse_size'])){ ?>
		<p class = "title">Mouse size</p>
		<div class="lineWrap">
			<ul id="mouseZoom">
				<li id="white_mouse" class="tree_column left mouse">Big white cursor</li>
				<li id="normal_mouse" class="tree_column mouse">Normal</li>
				<li id="black_mouse" class="tree_column right mouse">Big black cursor</li>
			</ul>
		</div>
<?php } ?>	
<?php	if (isset($options['ea_link_color'])){ ?>	
		<p class = "title">Links</p>
		<div class="lineWrap">
			<ul id="links">

				<li id="color_links" class="tree_column right">Color links</li>
				<li id="normal_link" class="tree_column">Normal</li>
				<li id="underline_links" class="tree_column left">Underline links</li>
			</ul>
		</div>
<?php } ?>
<?php	if (isset($options['ea_readable_font'])){ ?>
		<p class = "title">Readable Fonts</p>
		<div class="lineWrap">
			<ul id="readable_fonts">

				<li id="readable_font_arial" class="tree_column left">Arial</li>
				<li id="readable_font_normal" class="tree_column right">Original</li>
				<li id="readable_font_san" class="tree_column right">San sarif</li>
			</ul>
		</div>
<?php } ?>
<?php	if (isset($options['ea_animation'])){ ?>
		<p class = "title">Animation</p>
		<div class="lineWrap">
			<ul id="animation_onoff">
				<li id="animation_off" class="two_column left">Off</li>
				<li id="animation_on" class="two_column right">On</li>
			</ul>
		</div>
<?php } ?>
<?php	if (isset($options['ea_img_desc'])){ ?>
		<p class = "title">Image Describtion</p>
		<div class="lineWrap">
			<ul id="img_desc">
				<li id="img_desc_off" class="two_column left">Off</li>
				<li id="img_desc_on" class="two_column right">On</li>
			</ul>
		</div>
<?php } ?>
	</nav>
</div>

