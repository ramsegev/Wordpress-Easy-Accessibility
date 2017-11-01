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
 
   Single Post Template: easy_access_post_type
   Template Post Type: easy_post_type
*/

$args = array(
    'post_type' =>'easy_post_type',
    'posts_per_page' => 1
);
$postid = get_posts($args);

//$postid = 12;//This is page id or post id
$content_post = get_post($postid->ID);
$content = $content_post->post_content;
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
$loop = new WP_Query( $args );
/* while ( $loop->have_posts() ) : $loop->the_post();
  //the_title();
  echo '<div class="entry-content">';
  the_content();
  echo '</div>';
endwhile; */
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<?php 
while ( $loop->have_posts() ) : $loop->the_post();
	echo $content; 
endwhile;
?>
</body>
</html>
