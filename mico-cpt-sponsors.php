<?php
/**
 * MICO CPT Sponsors
 *
 * @package 	MICO_CPT_Sponsors
 * @author  	Malthe Milthers <malthe@milthers.dk>
 * @license 	@TODO [description]
 * @copyright 	2014 MICO
 * @link 		MICO, http://www.mico.dk
 *
 * @wordpress-plugin
 * Plugin Name: 	MICO CPT Sponsors
 * Plugin URI:		@TODO
 * Description: 	Registeres a translation ready Custom Post Type: "Sponsors".
 * Version: 		1.0.0
 * Author: 			Malthe Milthers
 * Author URI: 		http://www.malthemilthers.com
 * Text Domain: 	mico-cpt-Sponsors
 * License: 		@TODO
 * GitHub URI:		@TODO
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The plugin class
 */

class MICO_CPT_Sponsors {

	/**
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file and the name of the main plugin folder. 
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_slug = 'mico-cpt-sponsors';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 * @var      object
	 */
	protected static $instance = null;


	/**
	 * This class is only ment to be used once. 
	 * It basically works as a namespace.
	 *
	 * this insures that we can't call an instance of this class.
	 *
	 * @since  1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		
		// Event post type: Register post type
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Return the instance of this class.
	 *
	 * @since 		1.0.0 
	 * @return		object		A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( self::$instance == null ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		$domain = $this->plugin_slug;

		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
		$fullpath = dirname( basename( plugins_url() ) ) . '/' . basename(dirname(__FILE__))  . '/languages/';
	
		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, false, $fullpath );		
	
	}


	/**
	 * Register post types
	 *
	 * @since  1.0.0
	 */
	public function register_post_type() {

		if ( !post_type_exists( 'sponsor' ) ) :
			
			$labels = array(
				'name'               => _x( 'Sponsors', 'post type general name', $this->plugin_slug ),
				'singular_name'      => _x( 'Sponsor', 'post type singular name', $this->plugin_slug ),
				'menu_name'          => _x( 'Sponsors', 'admin menu', $this->plugin_slug ),
				'name_admin_bar'     => _x( 'Sponsor', 'add new on admin bar', $this->plugin_slug ),
				'add_new'            => _x( 'Add New', 'sponsor', $this->plugin_slug ),
				'add_new_item'       => __( 'Add New Sponsor', $this->plugin_slug ),
				'new_item'           => __( 'New Sponsor', $this->plugin_slug ),
				'edit_item'          => __( 'Edit Sponsor', $this->plugin_slug ),
				'view_item'          => __( 'View Sponsor', $this->plugin_slug ),
				'all_items'          => __( 'All Sponsors', $this->plugin_slug ),
				'search_items'       => __( 'Search Sponsors', $this->plugin_slug ),
				'parent_item_colon'  => __( 'Parent Sponsor:', $this->plugin_slug ),
				'not_found'          => __( 'No sponsors found.', $this->plugin_slug ),
				'not_found_in_trash' => __( 'No sponsors found in trash.', $this->plugin_slug )		
			);
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'exclude_from_search'=> false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => _x( 'sponsor', 'URL slug', $this->plugin_slug ) ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions'),
				'menu_icon'          => 'dashicons-heart'
			);
			register_post_type( 'sponsor', $args );

		endif;
	}



} // End of the MICO_CPT_Sponsors Class.

/*
 * Run the one and only instance of the plugins main class.
 */
add_action( 'plugins_loaded', array( 'MICO_CPT_Sponsors', 'get_instance' ) );

