<?php

if ( ! defined('ABSPATH')) exit; // if direct access 


add_action('related_post_main' ,'related_post_main_title');

function related_post_main_title($post_id){

    $related_post_settings = get_option( 'related_post_settings' );

    $headline_text= isset($related_post_settings['headline_text']) ? $related_post_settings['headline_text'] : '';
    ?>
    <div  class="headline" ><?php echo $headline_text; ?></div>
    <?php

}

add_action('related_post_main' ,'related_post_main_post_loop');

function related_post_main_post_loop($post_id){

    $related_post_settings = get_option( 'related_post_settings' );
    $post_type = get_post_type( $post_id );
    $post_ids = get_post_ids_by_taxonomy_terms($post_id);
    $orderby= isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : 'date';
    $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';
    $max_post_count= isset($related_post_settings['max_post_count']) ? $related_post_settings['max_post_count'] : 5;

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'post__in'=> $post_ids,
        'post__not_in' => $post_id,
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $max_post_count,
        'ignore_sticky_posts' => 1,
    );

    $args = apply_filters('related_post_query_args', $args);

    $wp_query = new WP_Query($args);



    ?>
    <div class="post-list">

        <?php

        if ($wp_query->have_posts()) {

            while ($wp_query->have_posts()) : $wp_query->the_post();

                $loop_post_id = get_the_id();

                ?>
                <div class="item">
                    <?php do_action('related_post_loop_item', $loop_post_id); ?>
                </div>
                <?php
            endwhile;

        }

        ?>

    </div>
    <?php

}


add_action('related_post_loop_item' ,'related_post_loop_item');

function related_post_loop_item($loop_post_id){

    $related_post_settings = get_option( 'related_post_settings' );
    $elements = isset($related_post_settings['elements']) ? $related_post_settings['elements'] : array();

    foreach ($elements as $elementIndex=>$elementData){

        do_action('related_post_loop_item_element_'.$elementIndex, $loop_post_id, $elementData);

    }

}


add_action('related_post_loop_item_element_post_title', 'related_post_loop_item_element_post_title', 10, 2);
function related_post_loop_item_element_post_title($loop_post_id, $elementData){

    $post_link = get_permalink($loop_post_id);
    $post_title = get_the_title($loop_post_id);

    ?>
    <div class="title">
        <a class="title" class="title" href="<?php echo $post_link; ?>"><?php echo $post_title; ?></a>
    </div>
    <?php
}