<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://dightinfotech.com/
 * @since      1.0.0
 *
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 * @author     dightinfotech <dightinfotech@gmail.com>
 */
class Blog_Web_Stories_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'blog-web-stories',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
