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

    $related_post_settings = get_option( 'related_post_settings' );
    $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : 'grid';

    require_once( related_post_plugin_dir . 'templates/related-post-hook.php');


    ob_start();

    ?>
    <div class="related-post <?php echo $layout_type; ?>">
        <?php

        do_action('related_post_main', $post_id);

        ?>
    </div>
    <?php

    if($layout_type == 'slider'){
        wp_enqueue_script('owl.carousel');
        wp_enqueue_style('owl.carousel');
    }



    return ob_get_clean();

}



















