<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://https://dightinfotech.com/
 * @since      1.0.0
 *
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 * @author     dightinfotech <dightinfotech@gmail.com>
 */
class Blog_Web_Stories {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Blog_Web_Stories_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'BLOG_WEB_STORIES_VERSION' ) ) {
			$this->version = BLOG_WEB_STORIES_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'blog-web-stories';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Blog_Web_Stories_Loader. Orchestrates the hooks of the plugin.
	 * - Blog_Web_Stories_i18n. Defines internationalization functionality.
	 * - Blog_Web_Stories_Admin. Defines all hooks for the admin area.
	 * - Blog_Web_Stories_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-blog-web-stories-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-blog-web-stories-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-blog-web-stories-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-blog-web-stories-public.php';

		$this->loader = new Blog_Web_Stories_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Blog_Web_Stories_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Blog_Web_Stories_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Blog_Web_Stories_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_stories_admin_menu' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_web_stories_checkbox_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_web_stories_checkbox_meta_box' );

		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'add_custom_meta_box' );
		$this->loader->add_action( 'save_post', $plugin_admin, 'save_custom_meta_box' );

		$this->loader->add_action( 'save_post', $plugin_admin, 'save_webstorie_link' );
		$this->loader->add_action( 'untrash_post', $plugin_admin, 'save_webstorie_link' );

		$this->loader->add_action( 'wp_trash_post', $plugin_admin, 'delete_webstorie_link' );

		$this->loader->add_action( 'init', $plugin_admin, 'my_custom_sitemap' );

		// 04-11-2024 -------------------------------
		$this->loader->add_action( 'save_post', $plugin_admin, 'cws_generate_web_story' );
		
		// indexing with Api ------
		$this->loader->add_action( 'publish_post', $plugin_admin, 'send_url_to_google_indexing', 10 , 1);
		$this->loader->add_action( 'wp_head', $plugin_admin, 'dynamic_favicon');
		
		$this->loader->add_action( 'admin_head', $plugin_admin, 'resize_menu_icon');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Blog_Web_Stories_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Blog_Web_Stories_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
