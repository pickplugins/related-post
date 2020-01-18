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

    $orderby = isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : array('post__in');
    $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';
    $max_post_count= isset($related_post_settings['max_post_count']) ? $related_post_settings['max_post_count'] : 5;
    $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : 'grid';

    $related_post_ids = get_post_meta( $post_id, 'related_post_ids', true );

    if(!empty($related_post_ids))
        $post_ids = array_merge($related_post_ids, $post_ids);


    $orderby = (!empty($orderby) && is_array($orderby)) ? implode(' ', $orderby) : '';

    $args = array(
        'post_type' => $post_type,
        'post_status' => 'publish',
        'post__in'=> $post_ids,
        'post__not_in' => array($post_id),
        'orderby' => $orderby,
        'order' => $order,
        'showposts' => $max_post_count,
        'ignore_sticky_posts' => 1,
    );

    $args = apply_filters('related_post_query_args', $args);

    $wp_query_new = new WP_Query($args);

    $slider_class = ($layout_type=='slider') ? 'owl-carousel' : '';

    ?>
    <div class="post-list <?php echo $slider_class; ?>">

        <?php

        if ($wp_query_new->have_posts()) {

            while ($wp_query_new->have_posts()) : $wp_query_new->the_post();

                $loop_post_id = get_the_id();

                ?>
                <div class="item">
                    <?php do_action('related_post_loop_item', $loop_post_id); ?>
                </div>
                <?php
            endwhile;

            //wp_reset_query();
            wp_reset_postdata();

        }

        ?>

    </div>
    <?php

}


add_action('related_post_loop_item' ,'related_post_loop_item');

function related_post_loop_item($loop_post_id){

    $related_post_settings = get_option( 'related_post_settings' );
    $elements = isset($related_post_settings['elements']) ? $related_post_settings['elements'] : array();

    foreach ($elements as $elementIndex=> $elementData){

        $hide = isset($elementData['hide']) ? $elementData['hide'] : 'no';

        if($hide != 'yes'){
            do_action('related_post_loop_item_element_'.$elementIndex, $loop_post_id, $elementData);
        }


    }

}


add_action('related_post_loop_item_element_post_title', 'related_post_loop_item_element_post_title', 10, 2);
function related_post_loop_item_element_post_title($loop_post_id, $elementData){

    $post_link = get_permalink($loop_post_id);
    $post_title = get_the_title($loop_post_id);
    $icon = isset($elementData['icon']) ? $elementData['icon'] : '';

    $related_post_settings = get_option( 'related_post_settings' );
    $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'disable';

    $post_link = ($enable_stats == 'enable') ? $post_link.'?to_id='.get_the_ID().'&from_id='.$loop_post_id : $post_link ;


    ?>

    <a class="title post_title" <?php echo apply_filters('related_post_element_link_attrs', 'post_title', $elementData); ?>  href="<?php echo $post_link; ?>">
        <?php
        if(!empty($icon)):
            ?>
            <span class="icon"><?php echo $icon;?></span>
            <?php
        endif;
        ?>
        <?php echo $post_title; ?>
    </a>

    <?php
}

add_action('related_post_loop_item_element_post_thumb', 'related_post_loop_item_element_post_thumb', 10, 2);
function related_post_loop_item_element_post_thumb($loop_post_id, $elementData){

    $thumb_size = isset($elementData['thumb_size']) ? $elementData['thumb_size'] : 'full';

    $post_thumb = wp_get_attachment_image_src( get_post_thumbnail_id($loop_post_id), $thumb_size );
    $thumb_url = isset($post_thumb['0']) ? $post_thumb['0'] : '';
    $post_link = get_permalink($loop_post_id);

    $related_post_settings = get_option( 'related_post_settings' );
    $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'disable';

    $post_link = ($enable_stats == 'enable') ? $post_link.'?to_id='.get_the_ID().'&from_id='.$loop_post_id : $post_link;


    ?>
    <div class="thumb post_thumb">
        <a <?php echo apply_filters('related_post_element_link_attrs', 'post_thumb', $elementData); ?> href="<?php echo $post_link; ?>"><img src="<?php echo $thumb_url; ?>"></a>
    </div>
    <?php
}


add_action('related_post_loop_item_element_post_excerpt', 'related_post_loop_item_element_post_excerpt', 10, 2);
function related_post_loop_item_element_post_excerpt($loop_post_id, $elementData){


    //echo '<pre>'.var_export($elementData, true).'</pre>';
    $post_link = get_permalink($loop_post_id);
    $word_count = isset($elementData['word_count']) ? $elementData['word_count'] : 20;
    $read_more_text = isset($elementData['read_more_text']) ? $elementData['read_more_text'] : __('Read more', '');
    $after_html = isset($elementData['after_html']) ? $elementData['after_html'] : '';


    $related_post_settings = get_option( 'related_post_settings' );
    $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'disable';

    $post_link = ($enable_stats == 'enable') ? $post_link.'?to_id='.get_the_ID().'&from_id='.$loop_post_id : $post_link;


    $post = get_post($loop_post_id);
    $post_excerpt = $post->post_excerpt;
    $post_content = $post->post_content;
    $post_excerpt = !empty($post_excerpt) ? strip_tags($post_excerpt) : strip_tags($post_content);
    $post_excerpt = wp_trim_words( $post_excerpt , $word_count, ' <a '.apply_filters('related_post_element_link_attrs', 'post_excerpt', $elementData).' class="read-more" href="'.$post_link.'"> '.$read_more_text.'</a>' );



    ?>
    <p class="excerpt post_excerpt">
        <?php echo $post_excerpt; ?>
    </p>
    <?php
}





add_action('related_post_main' ,'related_post_main_css');

function related_post_main_css($post_id){

    $related_post_settings = get_option( 'related_post_settings' );

    $elements = isset($related_post_settings['elements']) ? $related_post_settings['elements'] : array();
    $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : 'grid';
    $item_width = isset($related_post_settings['item_width']) ? $related_post_settings['item_width'] : array();
    $grid_item_margin = isset($related_post_settings['grid_item_margin']) ? $related_post_settings['grid_item_margin'] : '10px';
    $grid_item_padding = isset($related_post_settings['grid_item_padding']) ? $related_post_settings['grid_item_padding'] : '0px';
    $grid_item_align = isset($related_post_settings['grid_item_align']) ? $related_post_settings['grid_item_align'] : 'left';

    $headline_text_font_size = isset($related_post_settings['headline_text_style']['font_size']) ? $related_post_settings['headline_text_style']['font_size'] : '';
    $headline_text_color = isset($related_post_settings['headline_text_style']['color']) ? $related_post_settings['headline_text_style']['color'] : '';
    $headline_text_custom_css = isset($related_post_settings['headline_text_style']['custom_css']) ? $related_post_settings['headline_text_style']['custom_css'] : '';

    //var_dump($item_width);

    ?>

    <style type="text/css">
        .related-post{}
        .related-post .post-list{
        <?php if(!empty($grid_item_align)):?>
            text-align:<?php echo $grid_item_align; ?>;
        <?php endif; ?>
        }
        .related-post .post-list .item{
        <?php if(!empty($grid_item_width) && $layout_type == 'grid'):?>
            width:<?php echo $grid_item_width; ?>;
        <?php endif; ?>
        <?php if(!empty($grid_item_margin)):?>
            margin:<?php echo $grid_item_margin; ?>;
        <?php endif; ?>
        <?php if(!empty($grid_item_padding)):?>
            padding:<?php echo $grid_item_padding; ?>;
        <?php endif; ?>
        }
        .related-post .headline{
        <?php if(!empty($headline_text_font_size)): ?>
            font-size:<?php echo $headline_text_font_size; ?>;
        <?php endif; ?>
        <?php if(!empty($headline_text_color)): ?>
            color:<?php echo $headline_text_color; ?>;
        <?php endif; ?>
        <?php if(!empty($headline_text_custom_css)): ?>
            <?php echo $headline_text_custom_css; ?>
        <?php endif; ?>
        }

        <?php



        if(!empty($elements)):
            foreach ($elements as $elementIndex  => $elementData){

                $font_size = isset($elementData['font_size']) ? $elementData['font_size'] : '14px';
                $font_color = isset($elementData['font_color']) ? $elementData['font_color'] : '#999';
                $margin = isset($elementData['margin']) ? $elementData['margin'] : '10px';
                $padding = isset($elementData['padding']) ? $elementData['padding'] : '0px';
                $line_height = isset($elementData['line_height']) ? $elementData['line_height'] : '';

                $custom_css = isset($elementData['custom_css']) ? $elementData['custom_css'] : '';


                if($elementIndex == 'post_thumb'){
                     $max_height = isset($elementData['max_height']) ? $elementData['max_height'] : '';
                    ?>
                    .related-post .post-list .item .<?php echo $elementIndex; ?>{
                        <?php if(!empty($max_height)): ?>
                            max-height:<?php echo $max_height; ?>;
                        <?php endif; ?>
                        <?php if(!empty($margin)): ?>
                            margin:<?php echo $margin; ?>;
                        <?php endif; ?>
                        <?php if(!empty($padding)): ?>
                            padding:<?php echo $padding; ?>;
                        <?php endif; ?>
                        <?php if(!empty($line_height)): ?>
                            line-height:<?php echo $line_height; ?>;
                        <?php endif; ?>
                        display: block;
                        <?php echo $custom_css; ?>
                    }
                    <?php

                }elseif ($elementIndex == 'post_title'){

                    ?>
                    .related-post .post-list .item .<?php echo $elementIndex; ?>{
                        <?php if(!empty($font_size)): ?>
                            font-size:<?php echo $font_size; ?>;
                        <?php endif; ?>
                        <?php if(!empty($font_color)): ?>
                            color:<?php echo $font_color; ?>;
                        <?php endif; ?>
                        <?php if(!empty($margin)): ?>
                            margin:<?php echo $margin; ?>;
                        <?php endif; ?>
                        <?php if(!empty($padding)): ?>
                            padding:<?php echo $padding; ?>;
                        <?php endif; ?>
                        <?php if(!empty($line_height)): ?>
                            line-height:<?php echo $line_height; ?>;
                        <?php endif; ?>
                        display: block;
                        text-decoration: none;
                        <?php echo $custom_css; ?>
                    }
                    <?php

                }elseif ($elementIndex == 'post_excerpt'){
                    ?>
                    .related-post .post-list .item .<?php echo $elementIndex; ?>{
                        <?php if(!empty($font_size)): ?>
                            font-size:<?php echo $font_size; ?>;
                        <?php endif; ?>
                        <?php if(!empty($font_color)): ?>
                            color:<?php echo $font_color; ?>;
                        <?php endif; ?>
                        <?php if(!empty($margin)): ?>
                            margin:<?php echo $margin; ?>;
                        <?php endif; ?>
                        <?php if(!empty($padding)): ?>
                            padding:<?php echo $padding; ?>;
                        <?php endif; ?>
                        <?php if(!empty($line_height)): ?>
                            line-height:<?php echo $line_height; ?>;
                        <?php endif; ?>
                        display: block;
                        text-decoration: none;
                        <?php echo $custom_css; ?>
                    }
                    <?php
                }else{
                    do_action('related_post_element_css_'.$elementIndex, $elementData );
                }
            }
        endif;

        ?>

        <?php

        if($layout_type=='slider'):
        ?>
        .related-post .owl-dots .owl-dot {
        <?php if(!empty($slider_pagination_bg)):?>
            background:<?php echo $slider_pagination_bg; ?>;
        <?php endif; ?>
        <?php if(!empty($slider_pagination_text_color)):?>
            color:<?php echo $slider_pagination_text_color; ?>;
        <?php endif; ?>
        }
        <?php
        endif;

        ?>



        <?php


        if($layout_type == 'grid' || $layout_type == 'list'){

            ?>
            @media only screen and (min-width: 1024px ){
                .related-post .post-list .item{
                    width: <?php echo isset($item_width['large']) ?  $item_width['large'] : ''; ?>;
                }
            }

            @media only screen and ( min-width: 768px ) and ( max-width: 1023px ) {
                .related-post .post-list .item{
                    width: <?php echo isset($item_width['medium']) ?  $item_width['medium'] : ''; ?>;
                }
            }

            @media only screen and ( min-width: 0px ) and ( max-width: 767px ){
                .related-post .post-list .item{
                    width: <?php echo isset($item_width['small']) ?  $item_width['small'] : ''; ?>;
                }
            }

            <?php



        }



        ?>



    </style>
    <?php

}


add_action('related_post_main' ,'related_post_main_slider_scripts');

function related_post_main_slider_scripts($post_id){

    $related_post_settings = get_option( 'related_post_settings' );
    $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : 'grid';
    $slider_column_number_desktop = isset($related_post_settings['slider']['column_desktop']) ? $related_post_settings['slider']['column_desktop'] : 3;
    $slider_column_number_tablet = isset($related_post_settings['slider']['column_tablet']) ? $related_post_settings['slider']['column_tablet'] : 2;
    $slider_column_number_mobile = isset($related_post_settings['slider']['column_mobile']) ? $related_post_settings['slider']['column_mobile'] : 1;
    $slider_slide_speed = isset($related_post_settings['slider']['slide_speed']) ? $related_post_settings['slider']['slide_speed'] : 1000;
    $slider_pagination_speed = isset($related_post_settings['slider']['pagination_speed']) ? $related_post_settings['slider']['pagination_speed'] : 1200;
    $slider_auto_play = isset($related_post_settings['slider']['auto_play']) ? $related_post_settings['slider']['auto_play'] : 'true';
    $slider_rewind = isset($related_post_settings['slider']['rewind']) ? $related_post_settings['slider']['rewind'] : 'true';
    $slider_loop = isset($related_post_settings['slider']['loop']) ? $related_post_settings['slider']['loop'] : 'true';
    $slider_center = isset($related_post_settings['slider']['center']) ? $related_post_settings['slider']['center'] : 'true';
    $slider_stop_on_hover = isset($related_post_settings['slider']['stop_on_hover']) ? $related_post_settings['slider']['stop_on_hover'] : 'true';
    $slider_navigation = isset($related_post_settings['slider']['navigation']) ? $related_post_settings['slider']['navigation'] : 'true';
    $slider_pagination = isset($related_post_settings['slider']['pagination']) ? $related_post_settings['slider']['pagination'] : 'true';
    $slider_pagination_count = isset($related_post_settings['slider']['pagination_count']) ? $related_post_settings['slider']['pagination_count'] : 'true';
    $slider_rtl = isset($related_post_settings['slider']['rtl']) ? $related_post_settings['slider']['rtl'] : 'true';

    if($layout_type=='slider'):
        ?>
        <script>
        jQuery(document).ready(function($){
            $(".related-post .post-list").owlCarousel({
                items :<?php echo $slider_column_number_desktop; ?>,
                responsiveClass:true,
                responsive:{
                    576:{
                        items:<?php echo $slider_column_number_mobile; ?>,
                    },
                    992:{
                        items:<?php echo $slider_column_number_tablet; ?>,
                    },
                    1200:{
                        items:<?php echo $slider_column_number_desktop; ?>,
                    }
                },
                <?php if(!empty($slider_rewind)): ?>
                rewind: <?php echo $slider_rewind; ?>,
                <?php endif;?>
                <?php if(!empty($slider_loop)): ?>
                loop: <?php echo $slider_loop; ?>,
                <?php endif;?>
                <?php if(!empty($slider_center)): ?>
                center: <?php echo $slider_center; ?>,
                <?php endif;?>
                <?php if(!empty($slider_auto_play)): ?>
                autoplay: <?php echo $slider_auto_play; ?>,
                autoplayHoverPause: <?php echo $slider_stop_on_hover; ?>,
                <?php endif;?>
                <?php if(!empty($slider_navigation)): ?>
                nav: <?php echo $slider_navigation; ?>,
                navSpeed: <?php echo $slider_slide_speed; ?>,
                navText : ['<i class="fas fa-chevron-left"></i>','<i class="fas fa-chevron-right"></i>'],
                <?php endif;?>
                <?php if(!empty($slider_pagination)): ?>
                dots: <?php echo $slider_pagination; ?>,
                dotsSpeed: <?php echo $slider_pagination_speed; ?>,
                navText : ["",""],
                <?php endif;?>
                <?php if(!empty($slider_touch_drag)): ?>
                touchDrag: <?php echo $slider_touch_drag; ?>,
                <?php endif;?>
                <?php if(!empty($slider_mouse_drag)): ?>
                mouseDrag: <?php echo $slider_mouse_drag; ?>,
                <?php endif;?>
                <?php if(!empty($slider_rtl)): ?>
                rtl: <?php echo $slider_rtl; ?>,
                <?php endif;?>

            });
        });
        </script>
    <?php
    endif;

}

