<?php
/*
Plugin Name: Related Post
Plugin URI: http://wordpress.org/plugins/related-post/
Description: Display related posts under post content on single page and excerpt on archive pages.
Version: 2.0.18
Author: PickPlugins
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
        //require_once( related_post_plugin_dir . 'includes/class-notices.php');
        require_once( related_post_plugin_dir . 'includes/class-post-meta.php');
        require_once( related_post_plugin_dir . 'includes/class-settings-tabs.php');
        require_once( related_post_plugin_dir . 'includes/class-settings-tabs-reviews.php');


        require_once( related_post_plugin_dir . 'includes/class-data-upgrade.php');

        // functions
		require_once( related_post_plugin_dir . 'includes/functions.php');
        require_once( related_post_plugin_dir . 'includes/functions-settings.php');

		// Shortcodes
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


		}
	
	
	
	public function _textdomain() {

	    // Global files
        $locale = apply_filters( 'plugin_locale', get_locale(), 'related-post' );
        load_textdomain('related-post', WP_LANG_DIR .'/related-post/related-post-'. $locale .'.mo' );

        // Plugin files
        load_plugin_textdomain( 'related-post' , false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	
	
	function _front_scripts(){




        wp_register_style('related-post', related_post_plugin_url.'assets/front/css/related-post.css');
        wp_register_style('font-awesome-5', related_post_plugin_url.'assets/front/css/fontawesome.css');

        wp_register_script('owl.carousel', related_post_plugin_url.'/assets/front/js/owl.carousel.min.js' , array( 'jquery' ));
        wp_register_style('owl.carousel', related_post_plugin_url.'assets/front/css/owl.carousel.min.css');


	}
	
	
	function _admin_scripts(){




		wp_enqueue_script('related_post_js', related_post_plugin_url.'assets/admin/js/scripts.js' , array( 'jquery' ));
		wp_localize_script('related_post_js', 'related_post_ajax', array( 'related_post_ajaxurl' => admin_url( 'admin-ajax.php')));

        wp_register_style('font-awesome-5', related_post_plugin_url.'assets/front/css/fontawesome.css');

		// settings-tabs framework
        wp_register_script('settings-tabs', related_post_plugin_url.'assets/admin/js/settings-tabs.js' , array( 'jquery' ));
        wp_register_style('settings-tabs', related_post_plugin_url.'assets/admin/css/settings-tabs.css');


	}
	
	
	
}

new RelatedPost();



