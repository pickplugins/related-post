<?php


if ( ! defined('ABSPATH')) exit;  // if direct access 
	

add_action('related_post_settings_content_general', 'related_post_settings_content_general');

if(!function_exists('related_post_settings_content_general')) {
    function related_post_settings_content_general($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );

        $display_auto = isset($related_post_settings['display_auto']) ? $related_post_settings['display_auto'] : 'yes';
        $post_types = isset($related_post_settings['post_types']) ? $related_post_settings['post_types'] : array('post');
        $headline_text = isset($related_post_settings['headline_text']) ? $related_post_settings['headline_text'] : __('Related Post','');

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general option to getting started.', 'job-board-manager'); ?></p>

            <?php

            $args = array(
                'id'		=> 'display_auto',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Display automatically','job-board-manager'),
                'details'	=> __('Display automatically related post under post content.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $display_auto,
                'default'		=> 'yes',
                'args'		=> array('yes'=>__('Yes','related-post'), 'no'=>__('No','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $post_types_list = get_post_types( '', 'names' );
            $post_types_array = array();

            foreach ( $post_types_list as $post_type ) {

                $obj = get_post_type_object($post_type);
                $singular_name = $obj->labels->singular_name;
                $post_types_array[$post_type] = $singular_name;
            }

            //echo '<pre>'.var_export($post_types_array, true).'</pre>';

            $args = array(
                'id'		=> 'post_types',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Choose post types','job-board-manager'),
                'details'	=> __('Display related post automatically under selected post types.','job-board-manager'),
                'type'		=> 'checkbox',
                'value'		=> $post_types,
                'default'		=> array('post'),
                'style'		=> array('inline' => false),
                'args'		=> $post_types_array,
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'headline_text',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Title text','job-board-manager'),
                'details'	=> __('Custom text for related post title.','job-board-manager'),
                'type'		=> 'text',
                'value'		=> $headline_text,
                'default'		=> __('Related Post',''),
            );

            $settings_tabs_field->generate_field($args);

            ?>


        </div>
    <?php


    }
}


add_action('related_post_settings_content_style', 'related_post_settings_content_style');

if(!function_exists('related_post_settings_content_style')) {
    function related_post_settings_content_style($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );

        $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : 'grid';
        $grid_item_width = isset($related_post_settings['grid_item_width']) ? $related_post_settings['grid_item_width'] : '45%';
        $grid_item_margin = isset($related_post_settings['grid_item_margin']) ? $related_post_settings['grid_item_margin'] : '10px';
        $grid_item_padding = isset($related_post_settings['grid_item_padding']) ? $related_post_settings['grid_item_padding'] : '10px';
        $grid_item_align = isset($related_post_settings['grid_item_align']) ? $related_post_settings['grid_item_align'] : 'left';

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general option to getting started.', 'job-board-manager'); ?></p>

            <?php

            $args = array(
                'id'		=> 'layout_type',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Layout type','job-board-manager'),
                'details'	=> __('Choose layout type.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $layout_type,
                'default'		=> 'grid',
                'args'		=> array('grid'=>__('Grid','related-post'), 'slider'=>__('Slider','related-post'), 'list'=>__('List','related-post')  ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'grid_item_width',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item width','job-board-manager'),
                'details'	=> __('Set item width.','job-board-manager'),
                'type'		=> 'text',
                'value'		=> $grid_item_width,
                'default'		=> '45%',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'grid_item_margin',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item margin','job-board-manager'),
                'details'	=> __('Set item margin.','job-board-manager'),
                'type'		=> 'text',
                'value'		=> $grid_item_margin,
                'default'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'grid_item_padding',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item padding','job-board-manager'),
                'details'	=> __('Set item padding.','job-board-manager'),
                'type'		=> 'text',
                'value'		=> $grid_item_padding,
                'default'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'grid_item_align',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item text align','job-board-manager'),
                'details'	=> __('Set item text align.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $grid_item_align,
                'default'		=> 'left',
                'args'		=> array('left'=>__('Left','related-post'), 'center'=>__('Center','related-post'), 'right'=>__('Right','related-post')  ),
            );

            $settings_tabs_field->generate_field($args);




            ?>


        </div>
        <?php


    }
}


add_action('related_post_settings_content_query', 'related_post_settings_content_query');

if(!function_exists('related_post_settings_content_query')) {
    function related_post_settings_content_query($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );

        $orderby = isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : array('post__in');
        $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';
        $max_post_count = isset($related_post_settings['max_post_count']) ? $related_post_settings['max_post_count'] : 5;

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Post query settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose post query settings.', 'job-board-manager'); ?></p>

            <?php

            $args = array(
                'id'		=> 'orderby',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Query orderby','job-board-manager'),
                'details'	=> __('Choose related post query orderby','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $orderby,
                'multiple'		=> true,
                'default'		=> array('post__in'),
                'args'		=> array(
                    'ID'=>__('ID','related-post'),
                    'date'=>__('Date','related-post'),
                    'rand'=>__('Random','related-post'),
                    'comment_count'=>__('Comment count','related-post'),
                    'author'=>__('Author','related-post'),
                    'title'=>__('Title','related-post'),
                    'name'=>__('Name','related-post'),
                    'type'=>__('Type','related-post'),
                    'menu_order'=>__('Menu order','related-post'),
                    'post__in'=>__('post__in','related-post'),

                ),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'order',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Post order','job-board-manager'),
                'details'	=> __('Choose post query order.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $order,
                'default'		=> 'DESC',
                'args'		=> array('DESC'=>__('Descending','related-post'), 'ASC'=>__('Ascending','related-post')),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'max_post_count',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Max number of post','job-board-manager'),
                'details'	=> __('Maximum number of post to display.','job-board-manager'),
                'type'		=> 'text',
                'value'		=> $max_post_count,
                'default'		=> '5',
            );

            $settings_tabs_field->generate_field($args);








            ?>


        </div>
        <?php


    }
}


add_action('related_post_settings_content_elements', 'related_post_settings_content_elements');

if(!function_exists('related_post_settings_content_elements')) {
    function related_post_settings_content_elements($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );


        $elements = isset($related_post_settings['elements']) ? $related_post_settings['elements'] : array();
        $elements_index = isset($related_post_settings['elements_index']) ? $related_post_settings['elements_index'] : array();



        //$layout_items= $related_post_settings['layout_items'];


        //echo '<pre>'.var_export($related_post_settings, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Elements', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Customize post elements.', 'job-board-manager'); ?></p>

            <?php
            $get_intermediate_image_sizes =  get_intermediate_image_sizes();
            $get_intermediate_image_sizes = array_merge($get_intermediate_image_sizes,array('full'));

            $args = array(
                'id'		    => 'elements',
                'title'		    => __('Elements settings','job-board-manager'),
                'details'	    => __('Customize elements.','job-board-manager'),
                'type'		    => 'option_group_accordion',
                'value'		    => $elements,
                'sortable'		=> true,
                'default'		=> array(),
                'args_index'	=> $elements_index,
                'args_index_default'    => array('post_title', 'post_thumb', 'post_excerpt'),
                'args'          => array(
                    'post_title'    => array(
                        'title'     =>'Post title',
                        'options'   =>array(
                            array(
                                'id'		    => 'post_title',
                                'parent'		=> 'related_post_settings[elements_index]',
                                'title'		    => __('','text-domain'),
                                'details'	    => __('','text-domain'),
                                'type'		    => 'hidden',
                                'value'		=> 'post_title',
                                'default'		=> 'post_title',
                            ),

                            array(
                                'id'		    => 'font_size',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Font size','text-domain'),
                                'details'	    => __('Set custom font size.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'font_color',
                                'css_id'		    => 'post_title_font_color',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Font color','text-domain'),
                                'details'	    => __('Choose font color.','text-domain'),
                                'type'		    => 'colorpicker',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'line_height',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Line height','text-domain'),
                                'details'	    => __('Set line height.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => 'normal',
                            ),

                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),
                            array(
                                'id'		    => 'icon',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Icon','text-domain'),
                                'details'	    => __('Set icon.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '',
                            ),
                            array(
                                'id'		    => 'icon_font_size',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Icon font size','text-domain'),
                                'details'	    => __('Set icon font size.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '',
                            ),
                        ),
                    ),
                    'post_thumb' => array(
                        'title'=>'Post thumbnail',
                        'options'=>array(
                            array(
                                'id'		    => 'post_thumb',
                                'parent'		=> 'related_post_settings[elements_index]',
                                'title'		    => __('','text-domain'),
                                'details'	    => __('','text-domain'),
                                'type'		    => 'hidden',
                                'value'		=> 'post_thumb',
                                'default'		=> 'post_thumb',
                            ),
                            array(
                                'id'		    => 'thumb_size',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Thumbnail size','text-domain'),
                                'details'	    => __('Choose thumbnail size','text-domain'),
                                'type'		    => 'select',
                                'default'		=> '',
                                'args'   => $get_intermediate_image_sizes,
                            ),
                            array(
                                'id'		    => 'default_img',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Default thumbnail','text-domain'),
                                'details'	    => __('Set default thumbnail','text-domain'),
                                'type'		    => 'media_url',
                                'default'		=> '',
                            ),

                            array(
                                'id'		    => 'max_height',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Max height','text-domain'),
                                'details'	    => __('Set max height','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '200px',
                            ),
                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),


                        ),
                    ),
                    'post_excerpt' => array(
                        'title'=>'Post excerpt',
                        'options'=>array(
                            array(
                                'id'		    => 'post_excerpt',
                                'parent'		=> 'related_post_settings[elements_index]',
                                'title'		    => __('','text-domain'),
                                'details'	    => __('','text-domain'),
                                'type'		    => 'hidden',
                                'value'		=> 'post_excerpt',
                                'default'		=> 'post_excerpt',
                            ),
                            array(
                                'id'		    => 'font_size',

                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Font size','text-domain'),
                                'details'	    => __('Set custom font size.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'font_color',
                                'css_id'		    => 'excerpt_font_color',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Font color','text-domain'),
                                'details'	    => __('Choose font color.','text-domain'),
                                'type'		    => 'colorpicker',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'line_height',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Line height','text-domain'),
                                'details'	    => __('Set line height.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => 'normal',
                            ),

                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),
                        ),
                    ),
                ),
            );

            $settings_tabs_field->generate_field($args);








            ?>


        </div>
        <?php


    }
}
add_action('related_post_settings_content_slider', 'related_post_settings_content_slider');

if(!function_exists('related_post_settings_content_slider')) {
    function related_post_settings_content_slider($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );
        $slider_column_number_desktop = isset($related_post_settings['slider']['column_desktop']) ? $related_post_settings['slider']['column_desktop'] : 3;
        $slider_column_number_tablet = isset($related_post_settings['slider']['column_tablet']) ? $related_post_settings['slider']['column_tablet'] : 2;
        $slider_column_number_mobile = isset($related_post_settings['slider']['column_mobile']) ? $related_post_settings['slider']['column_mobile'] : 1;
        $slider_auto_play = isset($related_post_settings['slider']['auto_play']) ? $related_post_settings['slider']['auto_play'] : 'true';
        $slider_rewind = isset($related_post_settings['slider']['rewind']) ? $related_post_settings['slider']['rewind'] : 'true';
        $slider_loop = isset($related_post_settings['slider']['loop']) ? $related_post_settings['slider']['loop'] : 'true';
        $slider_center = isset($related_post_settings['slider']['center']) ? $related_post_settings['slider']['center'] : 'true';
        $slider_stop_on_hover = isset($related_post_settings['slider']['stop_on_hover']) ? $related_post_settings['slider']['stop_on_hover'] : 'true';
        $slider_navigation = isset($related_post_settings['slider']['navigation']) ? $related_post_settings['slider']['navigation'] : 'true';
        $slider_pagination = isset($related_post_settings['slider']['pagination']) ? $related_post_settings['slider']['pagination'] : 'true';
        $slider_pagination_count = isset($related_post_settings['slider']['pagination_count']) ? $related_post_settings['slider']['pagination_count'] : 'true';
        $slider_rtl = isset($related_post_settings['slider']['rtl']) ? $related_post_settings['slider']['rtl'] : 'true';

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Slider settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose slider settings.', 'job-board-manager'); ?></p>

            <?php

            $args = array(
                'id'		=> 'slider',
                'title'		=> __('Slider column count ','job-board-manager'),
                'details'	=> __('Set slider column count.','job-board-manager'),
                'type'		=> 'option_group',
                'options'		=> array(
                    array(
                        'id'		=> 'column_desktop',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In desktop','job-board-manager'),
                        'details'	=> __('min 1000px and max','job-board-manager'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_desktop,
                        'default'		=> 3,
                    ),
                    array(
                        'id'		=> 'column_tablet',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In tablet & small desktop','job-board-manager'),
                        'details'	=> __('900px max width','job-board-manager'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_tablet,
                        'default'		=> 2,
                    ),
                    array(
                        'id'		=> 'column_mobile',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In mobile','job-board-manager'),
                        'details'	=> __('479px max width','job-board-manager'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_mobile,
                        'default'		=> 1,
                    ),






                ),

            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'auto_play',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Auto play','job-board-manager'),
                'details'	=> __('Choose slider auto play.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_auto_play,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'rewind',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider rewind','job-board-manager'),
                'details'	=> __('Choose slider rewind.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'loop',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider loop','job-board-manager'),
                'details'	=> __('Choose slider loop.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'center',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider center','job-board-manager'),
                'details'	=> __('Choose slider center.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_center,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'stop_on_hover',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider stop on hover','job-board-manager'),
                'details'	=> __('Choose stop on hover.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_stop_on_hover,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'navigation',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider navigation','job-board-manager'),
                'details'	=> __('Choose slider navigation.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_navigation,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'pagination',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider pagination','job-board-manager'),
                'details'	=> __('Choose slider pagination.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_pagination,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_count',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider pagination count','job-board-manager'),
                'details'	=> __('Choose slider pagination count.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_pagination_count,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'rtl',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider rtl','job-board-manager'),
                'details'	=> __('Choose slider rtl.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $slider_rtl,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            ?>


        </div>
        <?php


    }
}

add_action('related_post_settings_content_stats', 'related_post_settings_content_stats');

if(!function_exists('related_post_settings_content_stats')) {
    function related_post_settings_content_stats($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );

        $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'no';

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Post query settings', 'job-board-manager'); ?></div>
            <p class="description section-description"><?php echo __('Choose post query settings.', 'job-board-manager'); ?></p>

            <?php



            $args = array(
                'id'		=> 'enable_stats',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Enable stats','job-board-manager'),
                'details'	=> __('Enable trace click on related post.','job-board-manager'),
                'type'		=> 'select',
                'value'		=> $enable_stats,
                'default'		=> 'yes',
                'args'		=> array('enable'=>__('Enable','related-post'), 'disable'=>__('Disable','related-post')),
            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>
            <ul>
            <?php

            global $wpdb;
            $table = $wpdb->prefix . "related_post_stats";
            $to_id = 'to_id';

            //$entries = $wpdb->get_results( "SELECT * FROM $table ORDER BY id DESC LIMIT 0, 10" );
            $entries = $wpdb->get_results("SELECT * FROM $table GROUP BY $to_id ORDER BY COUNT($to_id) DESC LIMIT 10", ARRAY_A);
            $count_to_id = $wpdb->get_results("SELECT to_id, COUNT(*) AS to_id FROM $table GROUP BY to_id ORDER BY COUNT(to_id) DESC LIMIT 10", ARRAY_A);
            //echo '<pre>'.var_export($entries, true).'</pre>';

            $i = 0;
            if(!empty($entries)):
                foreach($entries as $entry){
                    $to_id = $entry['to_id'];
                    $title = get_the_title($to_id);
                    ?>
                    <li>
                        <span><?php echo $count_to_id[$i]['to_id']; ?></span> <a href="#"><?php echo $title; ?></a>
                    </li>
                    <?php
                    $i++;
                }

            else:
                ?>
                <li>
                    No stats yet.
                </li>
                <?php

            endif;
            ?>
            </ul>
            <?php

            $top_10_html = ob_get_clean();

            $args = array(
                'id'		=> 'top_10',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Top 10 visited post today','job-board-manager'),
                'details'	=> __('','job-board-manager'),
                'type'		=> 'custom_html',
                'html'		=> $top_10_html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php


    }
}


