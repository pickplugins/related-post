<?php




if ( ! defined('ABSPATH')) exit; // if direct access 






add_filter('wp_head','related_post_count_stats');


function related_post_count_stats() {
	
	$related_post_settings = get_option( 'related_post_settings' );	
	$post_types= isset($related_post_settings['post_types']) ? $related_post_settings['post_types'] : array();
	$enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'disable';
	
	$gmt_offset = get_option('gmt_offset');
	$date = date('Y-m-d', strtotime('+'.$gmt_offset.' hour'));
	
	
	if(is_singular() && !empty($_GET['to_id']) && !empty($_GET['from_id'])){
		
		$from_id = sanitize_text_field($_GET['from_id']);
		$to_id = sanitize_text_field($_GET['to_id']);
		
		global $wpdb;
		$table = $wpdb->prefix . "related_post_stats";	
		
		$wpdb->query( $wpdb->prepare("INSERT INTO $table 
									( id, from_id, to_id, date )
									VALUES	( %d, %d, %d, %s )",
									array	( '', $from_id, $to_id, $date)
									
									));
									
									
		//echo '<pre>'.var_export($_GET).'</pre>';
		}
	
	
	
	
	}





function related_post_is_archive_display($archives){


    if(is_front_page() && is_home()){

        if(in_array('front_page', $archives)){
            return true;
        }

    }elseif( is_front_page()){
        if(in_array('home', $archives)){
            return true;
        }

    }elseif( is_home()){
        if(in_array('blog', $archives)){
            return true;
        }
    }else if( is_tag()){
        if(in_array('post_tag', $archives)){
            return true;
        }
    }else if( is_category()){
        if(in_array('category', $archives)){
            return true;
        }
    }

    else if(is_author()){
        if(in_array('author', $archives)){
            return true;
        }
    }else if(is_search()){
        if(in_array('search', $archives)){
            return true;
        }
    }else if(is_year()){
        if(in_array('year', $archives)){
            return true;
        }
    }else if(is_month()){
        if(in_array('month', $archives)){
            return true;
        }
    }else if(is_date()){
        if(in_array('date', $archives)){
            return true;
        }
    }else{
        return false;
    }





}

add_filter('the_excerpt','related_post_excerpt_display_auto');


function related_post_excerpt_display_auto($excerpt) {
    $post_id = get_the_ID();
    $post_type = get_post_type( $post_id );
    $related_post_settings = get_option( 'related_post_settings' );
    $display_auto = !empty($related_post_settings['display_auto']) ? $related_post_settings['display_auto'] : '';
    $archives = !empty($related_post_settings['archives']) ? $related_post_settings['archives'] : array();

    $post_types = !empty($related_post_settings['post_types']) ? $related_post_settings['post_types'] : array();
    $excerpt_positions = !empty($related_post_settings['excerpt_positions']) ? $related_post_settings['excerpt_positions'] : array();


    $is_archive_display = related_post_is_archive_display($archives);
    //echo '<pre>'.var_export($is_archive_display, true).'</pre>';

    $html = '';

    if($display_auto=='yes' && $is_archive_display && in_array($post_type, $post_types) && in_array('before', $excerpt_positions)){
        $html .= do_shortcode('[related_post post_id="'.$post_id.'"]');
    }

    $html .= $excerpt;

    if($display_auto=='yes' && $is_archive_display && in_array($post_type, $post_types) && in_array('after', $excerpt_positions)){
        $html .= do_shortcode('[related_post post_id="'.$post_id.'"]');
    }

    return $html;
}

add_filter('the_content','related_post_display_auto');


function related_post_display_auto($content) {

    //delete_option('related_post_settings');

    $post_id = get_the_ID();

	$post_type = get_post_type( $post_id );
	$related_post_settings = get_option( 'related_post_settings' );		
    $post_types = !empty($related_post_settings['post_types']) ? $related_post_settings['post_types'] : array();
    $archives = !empty($related_post_settings['archives']) ? $related_post_settings['archives'] : array();

    $display_auto = !empty($related_post_settings['display_auto']) ? $related_post_settings['display_auto'] : '';
    $content_positions = !empty($related_post_settings['content_positions']) ? $related_post_settings['content_positions'] : array();
    $paragraph_positions = !empty($related_post_settings['paragraph_positions']) ? $related_post_settings['paragraph_positions'] : array();
    $paragraph_positions = !empty($paragraph_positions) ? explode(',', $paragraph_positions) : array();
    $related_post_html  = do_shortcode('[related_post]');

    $is_archive_display = related_post_is_archive_display($archives);


    //echo '<pre>'.var_export($is_archive_display, true).'</pre>';
    //echo '<pre>'.var_export($is_archive_display, true).'</pre>';



	$html = '';

    if($display_auto=='yes'  && is_singular($post_types) && in_array($post_type, $post_types) && in_array('before', $content_positions)){
        $html .= do_shortcode('[related_post post_id="'.$post_id.'"]');
    }




    if(!empty($paragraph_positions) && is_singular($post_types)){
        $split_by = "\n";
        $content_blocks = explode( $split_by, $content);
        $content_blocks = array_filter($content_blocks);
        $content_blocks_count = count($content_blocks);

        $positions = array();
        foreach ($paragraph_positions as $position){
            if(strpos($position, 'N') !== false){

                $position = str_replace('N', $content_blocks_count, $position );
                $position = eval("return ($position);");
                $position = ($content_blocks_count == $position ) ? $position -1 : $position;

                $positions[] = $position;
            }else{
                $positions[] = $position;
            }
        }


        $content_html = '';

        $i = 1;
        foreach ($content_blocks as $content_block){

            if(in_array($i, $positions)){
                $content_html .= $content_block.$related_post_html;
            }else{
                $content_html .= $content_block;
            }

            $i++;
        }

        $html .= $content_html;

    }else{
        $html .= $content;
    }

	if($display_auto=='yes'  && is_singular($post_types) && in_array($post_type, $post_types) && in_array('after', $content_positions)){
       $html .= do_shortcode('[related_post post_id="'.$post_id.'"]');
	}

	return $html;
	
	}






function related_post_ajax_get_post_ids()
	{
			$response = array();
			$post_id 	= (int)sanitize_text_field($_POST['post_id']);
			$title 	= sanitize_text_field($_POST['title']);
		
			$post_type = get_post_type($post_id);
		
			$args = array('post_type'=>array('post'), 's'=>$title, 'post__not_in'=> array($post_id), 'posts_per_page'=>10);
			
			
			$wp_query = new WP_Query($args);
			
			$html = '';
			
			if($wp_query->have_posts()):
			
				while ($wp_query->have_posts()) : $wp_query->the_post();
				
					$post_id = get_the_id();
					$post_title = get_the_title();
				
					$html.= '<div post_id="'.$post_id.'" post_title="'.$post_title.'" class="item">'.get_the_title().'</div>';
				
				endwhile; 
				wp_reset_query();
			
			endif;
			
			$response['html'] = $html;
			
			echo json_encode($response);
		//echo json_encode($response);
		
		die();
	}

	add_action('wp_ajax_related_post_ajax_get_post_ids', 'related_post_ajax_get_post_ids');
	add_action('wp_ajax_nopriv_related_post_ajax_get_post_ids', 'related_post_ajax_get_post_ids');	






function get_post_ids_by_taxonomy_terms($post_id=0){

    $post_id = !empty($post_id) ? $post_id : get_the_ID();

    $post_type = get_post_type( $post_id );
    $taxonomy_terms = related_post_get_taxonomy_terms();
		
    if(!empty($taxonomy_terms)) {
        foreach($taxonomy_terms as $taxonomy => $term_ids){
            foreach($term_ids as $term_id){

                $wp_query = new WP_Query(
                    array(
                        'post_type' => $post_type,
                        'post_status' => 'publish',

                        'tax_query' => array(
                            array(
                               'taxonomy' => $taxonomy,
                               'field' => 'id',
                               'terms' => $term_id,
                            )
                        )
                    )
                );



            if ( $wp_query->have_posts() ) :
            $i = 0;
            while ( $wp_query->have_posts() ) : $wp_query->the_post();
                $post_ids[$i] = get_the_ID();

                $i++;
            endwhile;

            wp_reset_query();
            endif;


                }
            }

            //remove current post id

            $current_post_id = array(get_the_ID());
            $post_ids = array_diff($post_ids, $current_post_id);
        }
    else
        {
            $post_ids = array();
        }
			

		
		return $post_ids;
		
	}



function related_post_get_taxonomy_terms()
	{
   // global $post, $post_id;
    // get post by post id
    $post = get_post(get_the_ID());
    // get post type by post
    $post_type = $post->post_type;
    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type);
	$post_taxonomies_terms = array();
    foreach ($taxonomies as $taxonomy) {        

        // get the terms related to post
        $terms = get_the_terms( $post->ID, $taxonomy );
        if ( !empty( $terms ) )
			{
				$i = 0;
				foreach ( $terms as $term )
					{
						$post_taxonomies_terms[$taxonomy][$i] =$term->term_id; 
						$i++;
					}
				   
			}


    }

    return $post_taxonomies_terms;
}	
	

	













