<?php




if ( ! defined('ABSPATH')) exit; // if direct access 


add_shortcode('related_post', 'related_post_display');

function related_post_display($atts,$content = null) {

    $atts = shortcode_atts(
        array(
            'post_id' => "",
        ), $atts);

    $post_id = $atts['post_id'];
    $post_id = !empty($post_id) ? $post_id : get_the_ID();
    $post_type = get_post_type( $post_id );


    include( related_post_plugin_dir . 'templates/variables.php');
    include( related_post_plugin_dir . 'templates/related-post-hook.php');


    ob_start();

    ?>
    <div class="related-post">
        <?php

        do_action('related_post_main', $post_id);

        ?>
    </div>
    <?php
    include( related_post_plugin_dir . 'templates/css.php');
    return ob_get_clean();

}




/*


function related_post_display($atts,$content = null) {
	
		$atts = shortcode_atts(
			array(
				'themes' => "flat", //themes
			//	'tax_tag' => "", //themes				
				//'tax_cat' => "", //themes						

				), $atts);



			$themes = $atts['themes'];
			//$tax_tag = $atts['tax_tag'];			
			//$tax_cat = $atts['tax_cat'];			
			

			$html = '';
			$html .= $content;			

			if($themes== "text")
				{
					$html.= related_post_theme_text();
				}
			else if($themes== "flat")
				{
					$html.= related_post_theme_flat();
				}			
			else if($themes== "box")
				{
					$html.= related_post_theme_box();
				}
			else if($themes== "vertical")
				{
					$html.= related_post_theme_vertical();
				}				
				
				
			return $html;



		}

*/

//add_shortcode('related_post', 'related_post_display');














/*



function related_post_display_auto($content) {
	

		$themes =  get_option( 'related_post_display_themes' );;
		
		$html = '';
		$html .= $content;			

		if($themes== "text")
			{
				$html.= related_post_theme_text();
			}
		else if($themes== "flat")
			{
				$html.= related_post_theme_flat();
			}			
		else if($themes== "box")
			{
				$html.= related_post_theme_box();
			}
		else if($themes== "vertical")
			{
				$html.= related_post_theme_vertical();
			}				
				
				
				
				
				
	$related_post_display_posttype = get_option( 'related_post_display_posttype' );

	
	if($related_post_display_posttype==NULL)
		{
			$type ="none";
		}
	else
		{
			$type = "";
			foreach ( $related_post_display_posttype as  $post_type => $post_type_value )
				{
			
				$type .= $post_type.",";
				}
		}
	
	
		if(is_singular(explode(',',$type))){
			
			return $html;
			}
		else
			{
				return $content;
			}


		}


$related_post_display = get_option( 'related_post_display' );

if($related_post_display == 'yes')
	{
	add_filter('the_content','related_post_display_auto');
	}


*/


















