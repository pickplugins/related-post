<?php
/*
Plugin Name: Related Post
Plugin URI: http://wordpress.org/plugins/related-post/
Description: Display Related Post under post by tags and category.
Version: 2.0.6
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 



class RelatedPost{
	
	public function __construct(){

        define('related_post_plugin_url', plugins_url('/', __FILE__)  );
        define('related_post_plugin_dir', plugin_dir_path( __FILE__ ) );
        define('related_post_wp_url', 'http://wordpress.org/plugins/related-post/' );
        define('related_post_support_url', 'http://pickplugins.com/forum' );
        define('related_post_plugin_name', 'Related Post' );

        // Classes
        require_once( related_post_plugin_dir . 'includes/class-settings.php');
        require_once( related_post_plugin_dir . 'includes/class-functions.php');
        require_once( related_post_plugin_dir . 'includes/class-notices.php');
        require_once( related_post_plugin_dir . 'includes/class-post-meta.php');
        require_once( related_post_plugin_dir . 'includes/class-settings-tabs.php');


        // functions
		require_once( related_post_plugin_dir . 'includes/functions.php');
        require_once( related_post_plugin_dir . 'includes/functions-settings.php');

		// Shortcodes
		require_once( related_post_plugin_dir . 'includes/shortcodes.php');

		//settings-tab
        require_once( related_post_plugin_dir . 'includes/shortcodes.php');

        // Hooks
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' ); 
		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_admin_scripts' ) );
		add_action( 'plugins_loaded', array( $this, '_textdomain' ));

		register_activation_hook( __FILE__, array( $this, '_activation' ) );
		
		}

	public function _activation() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table = $wpdb->prefix .'related_post_stats';
		
		$sql = "CREATE TABLE IF NOT EXISTS ".$table ." (
			id int(100) NOT NULL AUTO_INCREMENT,
			from_id int(100) NOT NULL,
			to_id int(100) NOT NULL,
			date DATE NOT NULL,		
			UNIQUE KEY id (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );	
		


        $related_post_review_settings = get_option('related_post_review_settings');

        if(empty($related_post_review_settings)):

            $related_post_display = get_option( 'related_post_display' );
            $related_post_display_themes = get_option( 'related_post_display_themes' );
            $related_post_display_posttype = get_option( 'related_post_display_posttype' );
            $related_post_max_number = get_option( 'related_post_max_number' );
            $related_post_headline = get_option( 'related_post_headline' );
            $related_post_title_font_size = get_option( 'related_post_title_font_size' );
            $related_post_title_font_color = get_option( 'related_post_title_font_color' );
            $related_post_thumb_size = get_option( 'related_post_thumb_size' );
            $related_post_404_img_src = get_option( 'related_post_404_img_src' );


            $related_post_settings = array(
                'display_auto'=>$related_post_display,
                'post_types'=>$related_post_display_posttype,
                'max_post_count'=>$related_post_max_number,
                'headline_text'=>$related_post_headline,
                'layout_items'=>array(
                    'thumbnail'=> array (
                        'name' => 'Thumbnail',
                        'options' => array (
                            'thumb_size' => $related_post_thumb_size,
                            'default_img' => $related_post_404_img_src,
                            'thumb_linked' => 'yes',
                            'max_height' => '180px',
                            'margin' => '',
                            'padding' => '',
                            ),
                        ),
                    'title'=> array (
                        'name' => 'Title',
                        'options' =>
                        array (
                            'font_size' => $related_post_title_font_size,
                            'font_color' => $related_post_title_font_color,
                            'line_height' => 'normal',
                            'title_linked' => 'yes',
                            'margin' => '',
                            'padding' => '',
                            ),
                        ),
                    'excerpt'=> array (
                        'name' => 'Excerpt',
                        'options' =>
                        array (
                            'font_size' => '13px',
                            'font_color' => '#999',
                            'line_height' => 'normal',
                            'word_count' => '15',
                            'read_more_text' => '',
                            'margin' => '',
                            'padding' => '',
                            ),
                        ),
                    ),
                );

            update_option('related_post_settings', $related_post_settings);

			
			endif;
			

		
		
		
		}
	
	
	
	public function _textdomain() {

	    // Global files
        $locale = apply_filters( 'plugin_locale', get_locale(), 'related-post' );
        load_textdomain('related-post', WP_LANG_DIR .'/related-post/related-post-'. $locale .'.mo' );

        // Plugin files
        load_plugin_textdomain( 'related-post' , false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	
	
	function _front_scripts(){
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('related_post_js', related_post_plugin_url.'/assets/front/js/related-post-scripts.js' , array( 'jquery' ));
		wp_localize_script('related_post_js', 'related_post_ajax', array( 'related_post_ajaxurl' => admin_url( 'admin-ajax.php')));

		wp_enqueue_style('related-post', related_post_plugin_url.'assets/front/css/related-post.css');
		wp_enqueue_style('related-post-style', related_post_plugin_url.'assets/front/css/style.css');
		wp_enqueue_style('font-awesome', related_post_plugin_url.'assets/front/css/fontawesome.css');
        wp_register_style('font-awesome-5', related_post_plugin_url.'assets/front/css/font-awesome-5.css');


        wp_enqueue_script('owl.carousel.min', related_post_plugin_url.'/assets/front/js/owl.carousel.min.js' , array( 'jquery' ));
		wp_enqueue_style('owl.carousel', related_post_plugin_url.'assets/front/css/owl.carousel.css');

		

		
	}
	
	
	function _admin_scripts(){

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script('jquery-ui-accordion');

        //wp_enqueue_style('jquery-ui', related_post_plugin_url.'assets/admin/css/jquery-ui.min.css');
       // wp_enqueue_style( 'wp-jquery-ui' );
		// Color Picker
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script('wp-color-picker');
		
		wp_enqueue_script('related_post_js', related_post_plugin_url.'assets/admin/js/scripts.js' , array( 'jquery' ));
		wp_localize_script('related_post_js', 'related_post_ajax', array( 'related_post_ajaxurl' => admin_url( 'admin-ajax.php')));
		
		wp_enqueue_script('expandable', related_post_plugin_url.'assets/admin/js/expandable.js' , array( 'jquery' ));
	
		wp_enqueue_style('related-post-admin-style', related_post_plugin_url.'assets/admin/css/style.css');
        wp_register_style('font-awesome-5', related_post_plugin_url.'assets/front/css/fontawesome.css');

        wp_enqueue_style('related-post-expandable', related_post_plugin_url.'assets/admin/css/expandable.css');

		// settings-tab framework
        wp_register_script('settings-tabs', related_post_plugin_url.'assets/admin/js/settings-tabs.js' , array( 'jquery' ));
        wp_register_style('settings-tabs', related_post_plugin_url.'assets/admin/css/settings-tabs.css');



        //ParaAdmin framework
		wp_enqueue_style('ParaAdmin', related_post_plugin_url.'assets/admin/ParaAdmin/css/ParaAdmin.css');	

	}
	
	
	
}

new RelatedPost();



