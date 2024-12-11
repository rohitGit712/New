<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://dightinfotech.com/
 * @since             1.0.0
 * @package           Blog_Web_Stories
 *
 * @wordpress-plugin
 * Plugin Name:       Blog Web Stories
 * Plugin URI:        https://https://dightinfotech.com/
 * Description:       Blogs Web Stories
 * Version:           1.0.0
 * Author:            dightinfotech
 * Author URI:        https://https://dightinfotech.com//
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       blog-web-stories
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BLOG_WEB_STORIES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-blog-web-stories-activator.php
 */
function activate_blog_web_stories() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blog-web-stories-activator.php';
	Blog_Web_Stories_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-blog-web-stories-deactivator.php
 */
function deactivate_blog_web_stories() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-blog-web-stories-deactivator.php';
	Blog_Web_Stories_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_blog_web_stories' );
register_deactivation_hook( __FILE__, 'deactivate_blog_web_stories' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-blog-web-stories.php';

require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_blog_web_stories() {

	$plugin = new Blog_Web_Stories();
	$plugin->run();

}
run_blog_web_stories();
