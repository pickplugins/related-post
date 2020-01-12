<?php
if ( ! defined('ABSPATH')) exit;  // if direct access

class class_related_post_data_upgrade{

    public function __construct(){

		//add_action( 'admin_menu', array( $this, 'related_post_menu_init' ), 12 );

		}


	
	public function settings_update(){

        $related_post_settings = get_option( 'related_post_settings' );

        $related_post_settings_new = array();

        $display_auto = isset($related_post_settings['display_auto']) ? $related_post_settings['display_auto'] : 'yes';
        $related_post_settings_new['display_auto'] = $display_auto;


        $post_types = isset($related_post_settings['post_types']) ? $related_post_settings['post_types'] : array();

        $post_types_list = array();
        foreach ($post_types as $post_typeIndex => $post_type){
            $post_types_list[] = $post_typeIndex;
        }
        $related_post_settings_new['post_types'] = $post_types_list;

        $orderby = isset($related_post_settings['orderby']) ? $related_post_settings['orderby'] : 'post__in';
        $related_post_settings_new['orderby'] = array($orderby);

        $order = isset($related_post_settings['order']) ? $related_post_settings['order'] : 'DESC';
        $related_post_settings_new['order'] = $order;

        $max_post_count = isset($related_post_settings['max_post_count']) ? $related_post_settings['max_post_count'] : '5';
        $related_post_settings_new['max_post_count'] = $max_post_count;

        $headline_text = isset($related_post_settings['headline_text']) ? $related_post_settings['headline_text'] : '5';
        $related_post_settings_new['headline_text'] = $headline_text;

        $layout_type = isset($related_post_settings['layout_type']) ? $related_post_settings['layout_type'] : '5';
        $related_post_settings_new['layout_type'] = $layout_type;


        $grid_item_width = isset($related_post_settings['grid_item_width']) ? $related_post_settings['grid_item_width'] : '45%';

        $related_post_settings_new['item_width']['large'] = $grid_item_width;
        $related_post_settings_new['item_width']['medium'] = '90%';
        $related_post_settings_new['item_width']['small'] = '90%';

        $grid_item_margin = isset($related_post_settings['grid_item_margin']) ? $related_post_settings['grid_item_margin'] : '5px';
        $related_post_settings_new['grid_item_margin'] = $grid_item_margin;

        $grid_item_padding = isset($related_post_settings['grid_item_padding']) ? $related_post_settings['grid_item_padding'] : '0px';
        $related_post_settings_new['grid_item_padding'] = $grid_item_padding;

        $grid_item_align = isset($related_post_settings['grid_item_align']) ? $related_post_settings['grid_item_align'] : 'left';
        $related_post_settings_new['grid_item_align'] = $grid_item_align;


        $slider = isset($related_post_settings['slider']) ? $related_post_settings['slider'] : array();

        $related_post_settings_new['slider']['column_desktop'] = $slider['column_desktop'];
        $related_post_settings_new['slider']['column_tablet'] = $slider['column_tablet'];
        $related_post_settings_new['slider']['column_mobile'] = $slider['column_mobile'];
        $related_post_settings_new['slider']['slide_speed'] = $slider['slide_speed'];
        $related_post_settings_new['slider']['pagination_speed'] = $slider['pagination_speed'];
        $related_post_settings_new['slider']['auto_play'] = $slider['auto_play'];
        $related_post_settings_new['slider']['rewind'] = $slider['rewind'];
        $related_post_settings_new['slider']['loop'] = $slider['loop'];
        $related_post_settings_new['slider']['center'] = $slider['center'];
        $related_post_settings_new['slider']['stop_on_hover'] = $slider['stop_on_hover'];
        $related_post_settings_new['slider']['navigation'] = $slider['navigation'];
        $related_post_settings_new['slider']['navigation_position'] = $slider['navigation_position'];
        $related_post_settings_new['slider']['pagination'] = $slider['pagination'];
        $related_post_settings_new['slider']['pagination_count'] = $slider['pagination_count'];
        $related_post_settings_new['slider']['rtl'] = $slider['rtl'];

        $enable_stats = isset($related_post_settings['enable_stats']) ? $related_post_settings['enable_stats'] : 'enable';

        $related_post_settings_new['enable_stats'] = $enable_stats;


        $layout_items = isset($related_post_settings['layout_items']) ? $related_post_settings['layout_items'] : array();

        $related_post_settings_new['elements']['post_thumb']['hide'] = isset($layout_items['thumbnail']['options']['hide']) ? $layout_items['thumbnail']['options']['hide'] : 'no';
        $related_post_settings_new['elements']['post_thumb']['thumb_size'] = isset($layout_items['thumbnail']['options']['thumb_size']) ? $layout_items['thumbnail']['options']['thumb_size'] : 'full';
        $related_post_settings_new['elements']['post_thumb']['default_img'] = isset($layout_items['thumbnail']['options']['default_img']) ? $layout_items['thumbnail']['options']['default_img'] : '';
        $related_post_settings_new['elements']['post_thumb']['max_height'] = isset($layout_items['thumbnail']['options']['max_height']) ? $layout_items['thumbnail']['options']['max_height'] : '200px';
        $related_post_settings_new['elements']['post_thumb']['margin'] = isset($layout_items['thumbnail']['options']['margin']) ? $layout_items['thumbnail']['options']['margin'] : '';
        $related_post_settings_new['elements']['post_thumb']['padding'] = isset($layout_items['thumbnail']['options']['padding']) ? $layout_items['thumbnail']['options']['padding'] : '';
        $related_post_settings_new['elements']['post_thumb']['custom_css'] = isset($layout_items['thumbnail']['options']['custom_css']) ? $layout_items['thumbnail']['options']['custom_css'] : '';
        $related_post_settings_new['elements']['post_thumb']['after_html'] = isset($layout_items['thumbnail']['options']['custom_css']) ? $layout_items['thumbnail']['options']['after_html'] : '';


        $related_post_settings_new['elements']['post_title']['hide'] = isset($layout_items['title']['options']['hide']) ? $layout_items['title']['options']['hide'] : 'no';
        $related_post_settings_new['elements']['post_title']['font_size'] = isset($layout_items['title']['options']['font_size']) ? $layout_items['title']['options']['font_size'] : '14px';
        $related_post_settings_new['elements']['post_title']['font_color'] = isset($layout_items['title']['options']['font_color']) ? $layout_items['title']['options']['font_color'] : '#999999';
        $related_post_settings_new['elements']['post_title']['line_height'] = isset($layout_items['title']['options']['line_height']) ? $layout_items['title']['options']['line_height'] : '';
        $related_post_settings_new['elements']['post_title']['margin'] = isset($layout_items['title']['options']['margin']) ? $layout_items['title']['options']['margin'] : '';
        $related_post_settings_new['elements']['post_title']['padding'] = isset($layout_items['title']['options']['padding']) ? $layout_items['title']['options']['padding'] : '';
        $related_post_settings_new['elements']['post_title']['custom_css'] = isset($layout_items['title']['options']['custom_css']) ? $layout_items['title']['options']['custom_css'] : '';
        $related_post_settings_new['elements']['post_title']['after_html'] = isset($layout_items['title']['options']['custom_css']) ? $layout_items['title']['options']['after_html'] : '';
        $related_post_settings_new['elements']['post_title']['icon'] =  '';
        $related_post_settings_new['elements']['post_title']['icon_font_size'] =  '';




        $related_post_settings_new['elements']['post_excerpt']['hide'] = isset($layout_items['excerpt']['options']['hide']) ? $layout_items['excerpt']['options']['hide'] : 'no';
        $related_post_settings_new['elements']['post_excerpt']['font_size'] = isset($layout_items['excerpt']['options']['font_size']) ? $layout_items['excerpt']['options']['font_size'] : '14px';
        $related_post_settings_new['elements']['post_excerpt']['font_color'] = isset($layout_items['excerpt']['options']['font_color']) ? $layout_items['excerpt']['options']['font_color'] : '#999999';
        $related_post_settings_new['elements']['post_excerpt']['line_height'] = isset($layout_items['excerpt']['options']['line_height']) ? $layout_items['excerpt']['options']['line_height'] : '';
        $related_post_settings_new['elements']['post_excerpt']['word_count'] = isset($layout_items['excerpt']['options']['word_count']) ? $layout_items['excerpt']['options']['word_count'] : '20';
        $related_post_settings_new['elements']['post_excerpt']['read_more_text'] = isset($layout_items['excerpt']['options']['read_more_text']) ? $layout_items['excerpt']['options']['read_more_text'] : 'Read more';
        $related_post_settings_new['elements']['post_excerpt']['margin'] = isset($layout_items['excerpt']['options']['margin']) ? $layout_items['excerpt']['options']['margin'] : '';
        $related_post_settings_new['elements']['post_excerpt']['padding'] = isset($layout_items['excerpt']['options']['padding']) ? $layout_items['excerpt']['options']['padding'] : '';
        $related_post_settings_new['elements']['post_excerpt']['custom_css'] = isset($layout_items['excerpt']['options']['custom_css']) ? $layout_items['excerpt']['options']['custom_css'] : '';
        $related_post_settings_new['elements']['post_excerpt']['after_html'] = isset($layout_items['excerpt']['options']['custom_css']) ? $layout_items['excerpt']['options']['after_html'] : '';


        $related_post_settings_new['content_positions'] = array('after');
        $related_post_settings_new['excerpt_positions'] = array('after');

        $related_post_settings_new['paragraph_positions'] = '';




        update_option('related_post_settings', $related_post_settings_new);

    }
	










	}
	
//new class_related_post_data_upgrade();