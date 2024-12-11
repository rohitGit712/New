<?php

/**
 * Fired during plugin activation
 *
 * @link       https://https://dightinfotech.com/
 * @since      1.0.0
 *
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/includes
 * @author     dightinfotech <dightinfotech@gmail.com>
 */

use \Firebase\JWT\JWT;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client;
use Google\Service\Indexing;


class Blog_Web_Stories_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'webstorie_links';
        $charset_collate = $wpdb->get_charset_collate();

        // Check if the table already exists
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            // SQL to create the table
            $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                post_id bigint(20) NOT NULL,
                link varchar(255) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            // Include the upgrade script
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            
            // Create the table
            dbDelta($sql);
        }

        // Save links for all published posts
        self::save_links_for_existing_posts($table_name);
    }

    /**
     * Save links for all existing published posts.
     *
     * @param string $table_name The name of the table.
     * @since 1.0.0
     */
    private static function save_links_for_existing_posts($table_name) {
		global $wpdb;
	
		// Get all published posts
		$posts = $wpdb->get_results("SELECT ID FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'");
	
		foreach ($posts as $post) {
			$post_id = $post->ID;
			// Generate the dynamic link
			$link = home_url("/wp-content/plugins/blog-web-stories/story-view.php?post_id=$post_id");
			// Check if the link already exists in the table
			$existing_link = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE post_id = %d", $post_id));

			if (!$existing_link) {
				// Insert the link into the table if it does not exist
				$wpdb->insert(
					$table_name,
					array(
						'post_id' => $post_id,
						'link' => $link,
					)
				);
			}

			if (self::is_url_indexed($link) == false) {
				self::send_indexing_request($link);
			}
		}
	}


	private static function send_indexing_request($link) {
		$keyFilePath = plugin_dir_path(__FILE__) . 'admin/link-indexing.json'; 
	
		if (!file_exists($keyFilePath)) {
			error_log('Google API JSON key file not found: ' . $keyFilePath);
			return;
		}
	
		$client = new Google_Client();
		$client->setAuthConfig($keyFilePath);
		$client->addScope('https://www.googleapis.com/auth/indexing');
	
		$service = new Google_Service_Indexing($client);
	
		try {
			$urlNotification = new Google_Service_Indexing_UrlNotification();
			$urlNotification->setUrl($url);
			$urlNotification->setType('URL_UPDATED'); 
	
			$response = $service->urlNotifications->publish($urlNotification);
			return $response;
		} catch (Google_Service_Exception $e) {
			error_log('Service Exception: ' . $e->getMessage());
			error_log(print_r($e->getErrors(), true));  // Logs the error details to the debug log
		} catch (Exception $e) {
			error_log('Exception: ' . $e->getMessage());
		}
	}

	// Check url index or not  -----------------------------

	private static function is_url_indexed($link) {
		// Your Google Custom Search API credentials
		$apiKey = 'AIzaSyCg5bJx_xQPMkxmKRBGJ9_HBzw18RCxvF8';
		$cx = 'a25bb2469f20e485d'; // Custom Search Engine ID
		
		// Google Custom Search API endpoint
		$searchUrl = 'https://www.googleapis.com/customsearch/v1?q=' . urlencode($link) . '&key=' . $apiKey . '&cx=' . $cx;
		
		// Initialize cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $searchUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Ensure SSL certificate is verified
		$response = curl_exec($ch);
	
		// Check if there was an error with the cURL request
		if(curl_errno($ch)) {
			// Handle error
			echo 'cURL error: ' . curl_error($ch);
			curl_close($ch);
			return false;
		}
		
		curl_close($ch);

		if(!empty($response)){
			// Decode the JSON response
			$data = json_decode($response, true);
			
			// Check if the URL is found in the search results
			if (!empty($data['items'])) {
				foreach ($data['items'] as $item) {
					if (isset($item['link']) && $item['link'] === $link) {
						return true; // URL is indexed
					}
				}
			}
		}
		
		return false; // URL is not indexed
	}
}
