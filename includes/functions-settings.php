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
        $content_positions = isset($related_post_settings['content_positions']) ? $related_post_settings['content_positions'] : array();
        $excerpt_positions = isset($related_post_settings['excerpt_positions']) ? $related_post_settings['excerpt_positions'] : array();

        $paragraph_positions = isset($related_post_settings['paragraph_positions']) ? $related_post_settings['paragraph_positions'] : array();

        $archives = isset($related_post_settings['archives']) ? $related_post_settings['archives'] : array();

        $archives_array = array('front_page'=>'Front page', 'home' => 'Home', 'blog' => 'Blog', 'author' => 'Author', 'search' => 'Search', 'year' => 'Year', 'month' => 'Month', 'date' => 'Date');
        $all_post_types = get_post_types();
        $taxonomies = get_object_taxonomies( $all_post_types );


        foreach ($taxonomies as $taxonomy){
            $the_taxonomy = get_taxonomy($taxonomy);

            $archives_array[$taxonomy] = $the_taxonomy->labels->name;

        }


        //echo '<pre>'.var_export($archives_array, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general option to getting started.', 'related-post'); ?></p>

            <?php

            $args = array(
                'id'		=> 'display_auto',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Display automatically','related-post'),
                'details'	=> __('Display automatically related post under post content.','related-post'),
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
                'title'		=> __('Choose post types','related-post'),
                'details'	=> __('Display related post automatically under selected post types.','related-post'),
                'type'		=> 'checkbox',
                'value'		=> $post_types,
                'default'		=> array('post'),
                'style'		=> array('inline' => false),
                'args'		=> $post_types_array,
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'archives',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Choose archive','related-post'),
                'details'	=> __('Display related post automatically following archive page.','related-post'),
                'type'		=> 'checkbox',
                'value'		=> $archives,
                'default'		=> array(),
                'style'		=> array('inline' => false),
                'args'		=> $archives_array,
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'content_positions',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Content positions','related-post'),
                'details'	=> __('Display before or after content.','related-post'),
                'type'		=> 'checkbox',
                'value'		=> $content_positions,
                'default'		=> array(),
                'style'		=> array('inline' => false),
                'args'		=> array('before' => 'Before', 'after'=> 'After'),

            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'excerpt_positions',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Excerpt positions','related-post'),
                'details'	=> __('Display before or after excerpt.','related-post'),
                'type'		=> 'checkbox',
                'value'		=> $excerpt_positions,
                'default'		=> array(),
                'style'		=> array('inline' => false),
                'args'		=> array('before' => 'Before', 'after'=> 'After'),

            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'paragraph_positions',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Paragraph positions','related-post'),
                'details'	=> __('Display related post after n\'th paragraph. N is total paragraph count, use comma to separate.','related-post'),
                'type'		=> 'text',
                'value'		=> $paragraph_positions,
                'default'		=> '',
                'placeholder'   => '1,2,N-1',
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'headline_text',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Title text','related-post'),
                'details'	=> __('Custom text for related post title.','related-post'),
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
        $grid_item_margin = isset($related_post_settings['grid_item_margin']) ? $related_post_settings['grid_item_margin'] : '10px';
        $grid_item_padding = isset($related_post_settings['grid_item_padding']) ? $related_post_settings['grid_item_padding'] : '10px';
        $grid_item_align = isset($related_post_settings['grid_item_align']) ? $related_post_settings['grid_item_align'] : 'left';

        $item_width_large = isset($related_post_settings['item_width']['large']) ? $related_post_settings['item_width']['large'] : '45%';
        $item_width_medium = isset($related_post_settings['item_width']['medium']) ? $related_post_settings['item_width']['medium'] : '90%';
        $item_width_small = isset($related_post_settings['item_width']['small']) ? $related_post_settings['item_width']['small'] : '90%';

        //echo '<pre>'.var_export($related_post_settings, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('General settings', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Choose some general option to getting started.', 'related-post'); ?></p>

            <?php

            $args = array(
                'id'		=> 'layout_type',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Layout type','related-post'),
                'details'	=> __('Choose layout type.','related-post'),
                'type'		=> 'select',
                'value'		=> $layout_type,
                'default'		=> 'grid',
                'args'		=> array('grid'=>__('Grid','related-post'), 'slider'=>__('Slider','related-post'), 'list'=>__('List','related-post')  ),
            );

            $settings_tabs_field->generate_field($args);





            $args = array(
                'id'		=> 'item_width',
                'title'		=> __('Item width','related-post'),
                'details'	=> __('Set item width.','related-post'),
                'type'		=> 'option_group',
                'options'		=> array(
                    array(
                        'id'		=> 'large',
                        'parent'		=> 'related_post_settings[item_width]',
                        'title'		=> __('In desktop','related-post'),
                        'details'	=> __('min-width: 1200px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $item_width_large,
                        'default'		=> '45%',
                    ),
                    array(
                        'id'		=> 'medium',
                        'parent'		=> 'related_post_settings[item_width]',
                        'title'		=> __('In tablet & small desktop','related-post'),
                        'details'	=> __('min-width: 992px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $item_width_medium,
                        'default'		=> '90%',
                    ),
                    array(
                        'id'		=> 'small',
                        'parent'		=> 'related_post_settings[item_width]',
                        'title'		=> __('In mobile','related-post'),
                        'details'	=> __('max-width: 768px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $item_width_small,
                        'default'		=> '90%',
                    ),
                ),

            );

            $settings_tabs_field->generate_field($args);









            $args = array(
                'id'		=> 'grid_item_margin',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item margin','related-post'),
                'details'	=> __('Set item margin.','related-post'),
                'type'		=> 'text',
                'value'		=> $grid_item_margin,
                'default'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'grid_item_padding',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item padding','related-post'),
                'details'	=> __('Set item padding.','related-post'),
                'type'		=> 'text',
                'value'		=> $grid_item_padding,
                'default'		=> '10px',
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'grid_item_align',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Item text align','related-post'),
                'details'	=> __('Set item text align.','related-post'),
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
            <div class="section-title"><?php echo __('Post query settings', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Choose post query settings.', 'related-post'); ?></p>

            <?php

            $args = array(
                'id'		=> 'orderby',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Query orderby','related-post'),
                'details'	=> __('Choose related post query orderby','related-post'),
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
                'title'		=> __('Post order','related-post'),
                'details'	=> __('Choose post query order.','related-post'),
                'type'		=> 'select',
                'value'		=> $order,
                'default'		=> 'DESC',
                'args'		=> array('DESC'=>__('Descending','related-post'), 'ASC'=>__('Ascending','related-post')),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'max_post_count',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Max number of post','related-post'),
                'details'	=> __('Maximum number of post to display.','related-post'),
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


        //echo '<pre>'.var_export($elements, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Elements', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Customize post elements.', 'related-post'); ?></p>

            <?php
            $get_intermediate_image_sizes =  get_intermediate_image_sizes();
            $get_intermediate_image_sizes = array_merge($get_intermediate_image_sizes,array('full'));

            $args = array(
                'id'		    => 'elements',
                'title'		    => __('Elements settings','related-post'),
                'details'	    => __('Customize elements.','related-post'),
                'type'		    => 'option_group_accordion',
                'value'		    => $elements,
                'sortable'		=> true,
                'default'		=> array(),
                'args_index'	=> $elements_index,
                'args_index_default'    => array('post_title', 'post_thumb', 'post_excerpt'),
                'args_index_hide'	=> array('post_title' => false, 'post_thumb' => false , 'post_excerpt' => false),

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
                                'id'		=> 'hide',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		=> __('Hide','related-post'),
                                'details'	=> __('You can hide this element.','related-post'),
                                'type'		=> 'select',
                                'value'		=> isset($elements['post_title']['hide']) ? $elements['post_title']['hide'] : 'no',
                                //'multiple'		=> true,
                                'default'		=> 'no',
                                'args'		=> array(
                                    'no'=>__('No','related-post'),
                                    'yes'=>__('Yes','related-post'),
                                ),
                            ),

                            array(
                                'id'		    => 'font_size',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Font size','text-domain'),
                                'details'	    => __('Set custom font size.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['font_size']) ? $elements['post_title']['font_size'] : '',
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
                                'value'		=> isset($elements['post_title']['font_color']) ? $elements['post_title']['font_color'] : '',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'line_height',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Line height','text-domain'),
                                'details'	    => __('Set line height.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['line_height']) ? $elements['post_title']['line_height'] : '',
                                'default'		=> '',
                                'placeholder'   => 'normal',
                            ),

                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['margin']) ? $elements['post_title']['margin'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['padding']) ? $elements['post_title']['padding'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),
                            array(
                                'id'		    => 'icon',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Icon','text-domain'),
                                'details'	    => __('Set icon.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['icon']) ? $elements['post_title']['icon'] : '',
                                'default'		=> '',
                                'placeholder'   => '',
                            ),
                            array(
                                'id'		    => 'icon_font_size',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Icon font size','text-domain'),
                                'details'	    => __('Set icon font size.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_title']['icon_font_size']) ? $elements['post_title']['icon_font_size'] : '',
                                'default'		=> '',
                                'placeholder'   => '',
                            ),
                            array(
                                'id'		    => 'custom_css',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('Custom CSS','text-domain'),
                                'details'	    => __('Write custom CSS, do not write &lt;style>&lt;/style> tag','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_title']['custom_css']) ? $elements['post_title']['custom_css'] : '',
                                'placeholder'   => '',
                            ),

                            array(
                                'id'		    => 'after_html',
                                'parent'		=> 'related_post_settings[elements][post_title]',
                                'title'		    => __('After HTML','text-domain'),
                                'details'	    => __('Write custom HTML after post title, you can also use 3rd party shortcodes','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_title']['after_html']) ? $elements['post_title']['after_html'] : '',
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
                                'id'		=> 'hide',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		=> __('Hide','related-post'),
                                'details'	=> __('You can hide this element.','related-post'),
                                'type'		=> 'select',
                                'value'		=> isset($elements['post_thumb']['hide']) ? $elements['post_thumb']['hide'] : 'no',
                                //'multiple'		=> true,
                                'default'		=> 'no',
                                'args'		=> array(
                                    'no'=>__('No','related-post'),
                                    'yes'=>__('Yes','related-post'),
                                ),
                            ),

                            array(
                                'id'		    => 'thumb_size',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Thumbnail size','text-domain'),
                                'details'	    => __('Choose thumbnail size','text-domain'),
                                'type'		    => 'select',
                                'value'		=> isset($elements['post_thumb']['thumb_size']) ? $elements['post_thumb']['thumb_size'] : '',
                                'default'		=> '',
                                'args'   => $get_intermediate_image_sizes,
                            ),
                            array(
                                'id'		    => 'default_img',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Default thumbnail','text-domain'),
                                'details'	    => __('Set default thumbnail','text-domain'),
                                'type'		    => 'media_url',
                                'value'		=> isset($elements['post_thumb']['default_img']) ? $elements['post_thumb']['default_img'] : '',
                                'default'		=> '',
                            ),

                            array(
                                'id'		    => 'max_height',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Max height','text-domain'),
                                'details'	    => __('Set max height','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_thumb']['max_height']) ? $elements['post_thumb']['max_height'] : '',
                                'default'		=> '',
                                'placeholder'   => '200px',
                            ),
                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_thumb']['margin']) ? $elements['post_thumb']['margin'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_thumb']['padding']) ? $elements['post_thumb']['padding'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),
                            array(
                                'id'		    => 'custom_css',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('Custom CSS','text-domain'),
                                'details'	    => __('Write custom CSS, do not write &lt;style>&lt;/style> tag','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_thumb']['custom_css']) ? $elements['post_thumb']['custom_css'] : '',
                                'placeholder'   => '',
                            ),
                            array(
                                'id'		    => 'after_html',
                                'parent'		=> 'related_post_settings[elements][post_thumb]',
                                'title'		    => __('After HTML','text-domain'),
                                'details'	    => __('Write custom HTML after post thumbnail, you can also use 3rd party shortcodes','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_thumb']['after_html']) ? $elements['post_thumb']['after_html'] : '',
                                'placeholder'   => '',
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
                                'id'		=> 'hide',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		=> __('Hide','related-post'),
                                'details'	=> __('You can hide this element.','related-post'),
                                'type'		=> 'select',
                                'value'		=> isset($elements['post_excerpt']['hide']) ? $elements['post_excerpt']['hide'] : 'no',
                                //'multiple'		=> true,
                                'default'		=> 'no',
                                'args'		=> array(
                                    'no'=>__('No','related-post'),
                                    'yes'=>__('Yes','related-post'),
                                ),
                            ),
                            array(
                                'id'		    => 'word_count',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Excerpt word count','text-domain'),
                                'details'	    => __('Set custom number of word count for excerpt.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['word_count']) ? $elements['post_excerpt']['word_count'] : '',
                                'default'		=> '20',
                                'placeholder'   => '20',
                            ),

                            array(
                                'id'		    => 'read_more_text',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Read more text','text-domain'),
                                'details'	    => __('Set custom raed more text for excerpt.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['read_more_text']) ? $elements['post_excerpt']['read_more_text'] : '',
                                'default'		=> 'Read more',
                                'placeholder'   => 'Read more',
                            ),


                            array(
                                'id'		    => 'font_size',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Font size','text-domain'),
                                'details'	    => __('Set custom font size.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['font_size']) ? $elements['post_excerpt']['font_size'] : '',
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
                                'value'		=> isset($elements['post_excerpt']['font_color']) ? $elements['post_excerpt']['font_color'] : '',
                                'default'		=> '',
                                'placeholder'   => '14px',
                            ),
                            array(
                                'id'		    => 'line_height',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Line height','text-domain'),
                                'details'	    => __('Set line height.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['line_height']) ? $elements['post_excerpt']['line_height'] : '',
                                'default'		=> '',
                                'placeholder'   => 'normal',
                            ),

                            array(
                                'id'		    => 'margin',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Margin','text-domain'),
                                'details'	    => __('Set margin.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['margin']) ? $elements['post_excerpt']['margin'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),

                            array(
                                'id'		    => 'padding',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Padding','text-domain'),
                                'details'	    => __('Set padding.','text-domain'),
                                'type'		    => 'text',
                                'value'		=> isset($elements['post_excerpt']['padding']) ? $elements['post_excerpt']['padding'] : '',
                                'default'		=> '',
                                'placeholder'   => '10px',
                            ),
                            array(
                                'id'		    => 'custom_css',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('Custom CSS','text-domain'),
                                'details'	    => __('Write custom CSS, do not write &lt;style>&lt;/style> tag','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_excerpt']['custom_css']) ? $elements['post_excerpt']['custom_css'] : '',
                                'placeholder'   => '',
                            ),
                            array(
                                'id'		    => 'after_html',
                                'parent'		=> 'related_post_settings[elements][post_excerpt]',
                                'title'		    => __('After HTML','text-domain'),
                                'details'	    => __('Write custom HTML after post title, you can also use 3rd party shortcodes','text-domain'),
                                'type'		    => 'textarea',
                                'value'		=> isset($elements['post_excerpt']['after_html']) ? $elements['post_excerpt']['after_html'] : '',
                                'placeholder'   => '',
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

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('Slider settings', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Choose slider settings.', 'related-post'); ?></p>

            <?php

            $args = array(
                'id'		=> 'slider',
                'title'		=> __('Slider column count ','related-post'),
                'details'	=> __('Set slider column count.','related-post'),
                'type'		=> 'option_group',
                'options'		=> array(
                    array(
                        'id'		=> 'column_desktop',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In desktop','related-post'),
                        'details'	=> __('min-width: 1200px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_desktop,
                        'default'		=> 3,
                    ),
                    array(
                        'id'		=> 'column_tablet',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In tablet & small desktop','related-post'),
                        'details'	=> __('min-width: 992px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_tablet,
                        'default'		=> 2,
                    ),
                    array(
                        'id'		=> 'column_mobile',
                        'parent'		=> 'related_post_settings[slider]',
                        'title'		=> __('In mobile','related-post'),
                        'details'	=> __('min-width: 576px','related-post'),
                        'type'		=> 'text',
                        'value'		=> $slider_column_number_mobile,
                        'default'		=> 1,
                    ),
                ),

            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'slide_speed',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Navigation slide speed','related-post'),
                'details'	=> __('Set slide speed','related-post'),
                'type'		=> 'text',
                'value'		=> $slider_slide_speed,
                'default'		=> 1,
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'pagination_speed',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Dots slide speed','related-post'),
                'details'	=> __('Set dots slide speed','related-post'),
                'type'		=> 'text',
                'value'		=> $slider_pagination_speed,
                'default'		=> 1,
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'auto_play',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Auto play','related-post'),
                'details'	=> __('Choose slider auto play.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_auto_play,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'rewind',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider rewind','related-post'),
                'details'	=> __('Choose slider rewind.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'loop',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider loop','related-post'),
                'details'	=> __('Choose slider loop.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_rewind,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'center',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider center','related-post'),
                'details'	=> __('Choose slider center.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_center,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'stop_on_hover',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider stop on hover','related-post'),
                'details'	=> __('Choose stop on hover.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_stop_on_hover,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);




            $args = array(
                'id'		=> 'navigation',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider navigation','related-post'),
                'details'	=> __('Choose slider navigation.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_navigation,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'navigation_position',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider navigation position','related-post'),
                'details'	=> __('Choose slider navigation position.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_navigation,
                'default'		=> 'topright',
                'args'		=> array('topright'=>__('Top-right','related-post'), 'middle'=>__('Middle','related-post') , 'middle-fixed'=>__('Middle-fixed','related-post') ),
            );

            $settings_tabs_field->generate_field($args);



            $args = array(
                'id'		=> 'pagination',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider pagination','related-post'),
                'details'	=> __('Choose slider pagination.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_pagination,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'		=> 'pagination_count',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider pagination count','related-post'),
                'details'	=> __('Choose slider pagination count.','related-post'),
                'type'		=> 'select',
                'value'		=> $slider_pagination_count,
                'default'		=> 'true',
                'args'		=> array('true'=>__('True','related-post'), 'false'=>__('False','related-post')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'		=> 'rtl',
                'parent'		=> 'related_post_settings[slider]',
                'title'		=> __('Slider rtl','related-post'),
                'details'	=> __('Choose slider rtl.','related-post'),
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
            <div class="section-title"><?php echo __('Post query settings', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Choose post query settings.', 'related-post'); ?></p>

            <?php



            $args = array(
                'id'		=> 'enable_stats',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Enable stats','related-post'),
                'details'	=> __('Enable trace click on related post.','related-post'),
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
                'title'		=> __('Top 10 visited post today','related-post'),
                'details'	=> __('','related-post'),
                'type'		=> 'custom_html',
                'html'		=> $top_10_html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php


    }
}


add_action('related_post_settings_content_shortcodes', 'related_post_settings_content_shortcodes');

if(!function_exists('related_post_settings_content_shortcodes')) {
    function related_post_settings_content_shortcodes($tab){

        $settings_tabs_field = new settings_tabs_field();

        $related_post_settings = get_option( 'related_post_settings' );

        $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'no';

        //echo '<pre>'.var_export($display_auto, true).'</pre>';

        ?>
        <div class="section">
            <div class="section-title"><?php echo __('SHortcodes', 'related-post'); ?></div>
            <p class="description section-description"><?php echo __('Get shortcode and use anywhere you want.', 'related-post'); ?></p>

            <?php


            ob_start();
            ?>

            <p>Short-code for php file</p>
            <textarea onclick="this.select()">&#60;?php echo do_shortcode( '&#91;related_post&#93;' ); ?&#62;</textarea>
            <p class="description" >Short-code inside loop by dynamic post id you can use anywhere inside loop on .php files.</p>

            <p>Short-code for content</p>
            <textarea onclick="this.select()">[related_post]</textarea>

            <p class="description">Short-code inside content for fixed post id you can use anywhere inside content.</p>
            <?php

            $html = ob_get_clean();

            $args = array(
                'id'		=> 'shortcodes',
                'parent'		=> 'related_post_settings',
                'title'		=> __('Shortcodes','related-post'),
                'details'	=> __('','related-post'),
                'type'		=> 'custom_html',
                'html'		=> $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
        <?php


    }
}

