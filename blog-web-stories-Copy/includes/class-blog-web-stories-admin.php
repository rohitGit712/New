<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://dightinfotech.com/
 * @since      1.0.0
 *
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Blog_Web_Stories
 * @subpackage Blog_Web_Stories/admin
 * @author     dightinfotech <dightinfotech@gmail.com>
 */

class Blog_Web_Stories_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blog_Web_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blog_Web_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/blog-web-stories-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Blog_Web_Stories_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Blog_Web_Stories_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/blog-web-stories-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function add_stories_admin_menu() {
		add_menu_page(
			'Web Stories',            // Page title
			'Web Stories',            // Menu title
			'manage_options',     // Capability
			'stories',            // Menu slug
			'display_stories_page', // Function to display the page content
			'dashicons-format-gallery', // Icon (choose an appropriate icon)
			6                     // Position
		);

		function display_stories_page_old() {
			
			// Get the URL of the plugin directory
			$plugin_url = plugins_url('', __FILE__);
		
			?>
			<div class="wrap">
				<h1>Web Stories</h1>
				<div id="stories-container">
					<?php
					$args = array('post_type' => 'post', 'posts_per_page' => -1);
					$query = new WP_Query($args);
		
					if ($query->have_posts()) :
						while ($query->have_posts()) : $query->the_post(); ?>
							<div class="story" data-id="<?php the_ID(); ?>" style="margin: 10px; cursor: pointer;">
								<div class="story-image">
									<?php if (has_post_thumbnail()) : ?>
										<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" style="width: 100%;">
										<div class="story-title"><?php the_title(); ?></div>
										<div class="story-description">
											<p><?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?></p>
											<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata();
					else :
						echo '<p>No posts found.</p>';
					endif; ?>
				</div>
			</div>
		
			<style>
				#stories-container {
					display: flex;
					overflow-x: auto;
				}
				.story {
					position: relative;
					max-width: 200px;
					text-align: center;
				}
				.story-image {
					position: relative;
				}
				.story-title, .story-description {
					position: absolute;
					left: 0;
					right: 0;
					color: white;
					background: rgba(0, 0, 0, 0.7);
					padding: 5px 10px;
					text-align: center;
					transition: opacity 0.2s; /* Optional: Fade effect */
				}
				.story-title {
					bottom: 90%; /* Adjust to position on the image */
				}
				.story-description {
					bottom: 1%; /* Position it above the "Read More" link */
				}
				.story img {
					transition: transform 0.2s;
				}
				.story:hover img {
					transform: scale(1.05);
				}
				.read-more {
					display: inline-block;
					margin-top: 5px;
					text-decoration: none;
					color: #0073aa; /* Link color */
				}
				.read-more:hover {
					text-decoration: underline;
				}
			</style>
		
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const pluginUrl = '<?php echo esc_url(plugins_url('blog-web-stories/story-view.php')); ?>';
					document.querySelectorAll('.story').forEach(story => {
						story.addEventListener('click', () => {
							const postId = story.dataset.id;
							window.location.href = `${pluginUrl}?post_id=${postId}`;
						});
					});
				});
			</script>
		
			<?php
		}

		
		function display_stories_page_old_06_00() {		
			$plugin_url = plugins_url('', __FILE__);
			?>
			<div class="wrap">
				<h1>Web Stories</h1>
				<div id="stories-container">
					<?php
					$args = array('post_type' => 'post', 'posts_per_page' => -1);
					$query = new WP_Query($args);
		
					if ($query->have_posts()) :
						while ($query->have_posts()) : $query->the_post(); ?>
							<div class="story" data-id="<?php the_ID(); ?>">
								<div class="story-image">
									<?php if (has_post_thumbnail()) : ?>
										<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" style="width: 100%;">
										<div class="story-title"><?php the_title(); ?></div>
										<div class="story-description">
											<p><?php echo wp_trim_words(get_the_excerpt(), 10, '...'); ?></p> <!-- Reduced words -->
											<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata();
					else :
						echo '<div>Debug: No posts found!</div>'; // Debug line
					endif; ?>
				</div>
			</div>
		
			<style>
				#stories-container {
					display: flex;
					flex-wrap: wrap; /* Allow wrapping to new lines */
					gap: 15px; /* Space between stories */
					padding: 20px; /* Padding around the container */
					justify-content: flex-start; /* Align to the left */
				}
				.story {
					position: relative;
					max-width: 150px; /* Set maximum width to 150px */
					text-align: center;
					background: rgba(255, 255, 255, 0.9); /* Light background for contrast */
					border-radius: 10px; /* Rounded corners */
					box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow */
					overflow: hidden; /* Clip the child elements */
					transition: transform 0.2s; /* Transition for hover effect */
				}
				.story:hover {
					transform: scale(1.05); /* Slight scale on hover */
				}
				.story-image {
					position: relative;
				}
				.story-title, .story-description {
					position: absolute;
					left: 0;
					right: 0;
					color: #333;
					background: rgba(255, 255, 255, 0.8); /* Background for readability */
					padding: 5px; /* Reduced padding */
					text-align: center;
				}
				.story-title {
					top: 5px; /* Position title above the image */
					font-size: 14px; /* Decreased title font size */
					font-weight: bold; /* Bold title */
				}
				.story-description {
					bottom: 5px; /* Position description above the "Read More" link */
					font-size: 12px; /* Smaller description font size */
				}
				.read-more {
					display: inline-block;
					margin-top: 5px;
					text-decoration: none;
					color: #0073aa; /* Link color */
					font-weight: bold; /* Bold link */
				}
				.read-more:hover {
					text-decoration: underline;
				}
			</style>
		
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const pluginUrl = '<?php echo esc_url(plugins_url('blog-web-stories/story-view.php')); ?>';
					document.querySelectorAll('.story').forEach(story => {
						story.addEventListener('click', () => {
							const postId = story.dataset.id;
							window.location.href = `${pluginUrl}?post_id=${postId}`;
						});
					});
				});
			</script>
		
			<?php
		}	

		function display_stories_page() {	
			$plugin_url = plugins_url('', __FILE__);
			?>
			<div class="wrap">
				<h1>Web Stories</h1>
				<div id="stories-container">
					<?php
					// Modify the query to include a meta query
					$args = array(
						'post_type' => 'post',
						'posts_per_page' => -1,
						'meta_query' => array(
							array(
								'key' => '_show_on_web_stories',
								'value' => '1', // Only get posts where this meta key is '1'
								'compare' => '='
							)
						)
					);
		
					$query = new WP_Query($args);
		
					if ($query->have_posts()) :
						while ($query->have_posts()) : $query->the_post(); ?>
							<div class="story" data-id="<?php the_ID(); ?>">
								<div class="story-image">
									<?php if (has_post_thumbnail()) : ?>
										<img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" style="width: 100%;">
										<div class="story-title"><?php the_title(); ?></div>
										<div class="story-description">
											<p><?php echo wp_trim_words(get_the_excerpt(), 10, '...'); ?></p> <!-- Reduced words -->
											<a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endwhile;
						wp_reset_postdata();
					else :
						echo '<div>Debug: No posts found!</div>'; // Debug line
					endif; ?>
				</div>
			</div>
		
			<style>
				#stories-container {
					display: flex;
					flex-wrap: wrap; /* Allow wrapping to new lines */
					gap: 15px; /* Space between stories */
					padding: 20px; /* Padding around the container */
					justify-content: flex-start; /* Align to the left */
				}
				.story {
					position: relative;
					max-width: 150px; /* Set maximum width to 150px */
					text-align: center;
					background: rgba(255, 255, 255, 0.9); /* Light background for contrast */
					border-radius: 10px; /* Rounded corners */
					box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow */
					overflow: hidden; /* Clip the child elements */
					transition: transform 0.2s; /* Transition for hover effect */
				}
				.story:hover {
					transform: scale(1.05); /* Slight scale on hover */
				}
				.story-image {
					position: relative;
				}
				.story-title, .story-description {
					position: absolute;
					left: 0;
					right: 0;
					color: #333;
					background: rgba(255, 255, 255, 0.8); /* Background for readability */
					padding: 5px; /* Reduced padding */
					text-align: center;
				}
				.story-title {
					top: 5px; /* Position title above the image */
					font-size: 14px; /* Decreased title font size */
					font-weight: bold; /* Bold title */
				}
				.story-description {
					bottom: 5px; /* Position description above the "Read More" link */
					font-size: 12px; /* Smaller description font size */
				}
				.read-more {
					display: inline-block;
					margin-top: 5px;
					text-decoration: none;
					color: #0073aa; /* Link color */
					font-weight: bold; /* Bold link */
				}
				.read-more:hover {
					text-decoration: underline;
				}
			</style>
		
			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const pluginUrl = '<?php echo esc_url(plugins_url('blog-web-stories/story-view.php')); ?>';
					document.querySelectorAll('.story').forEach(story => {
						story.addEventListener('click', () => {
							const postId = story.dataset.id;
							window.location.href = `${pluginUrl}?post_id=${postId}`;
						});
					});
				});
			</script>
		
			<?php
		}
	}

	// Show on web Stories ---------------------------------

	// Add a custom checkbox meta box
	public function add_web_stories_checkbox_meta_box() {
		add_meta_box(
			'web_stories_checkbox_meta_box', // Unique ID
			'Show on Web Stories', // Box title
			'render_web_stories_checkbox_meta_box', // Content callback
			'post', // Post type
			'side' // Position: 'side', 'normal', or 'advanced'
		);


		function render_web_stories_checkbox_meta_box($post) {
			// Add a nonce field for security
			wp_nonce_field('web_stories_checkbox_nonce_action', 'web_stories_checkbox_nonce');
		
			// Retrieve the existing value (if any)
			$value = get_post_meta($post->ID, '_show_on_web_stories', true);
			?>
			<label for="show_on_web_stories">
				<input type="checkbox" id="show_on_web_stories" name="show_on_web_stories" value="1" <?php checked($value, '1'); ?> />
				Show on Web Stories
			</label>
			<?php
		}
	}

	// Render the checkbox meta box


	// Save the checkbox value
	public function save_web_stories_checkbox_meta_box($post_id) {
		// Check if our nonce is set.
		if (!isset($_POST['web_stories_checkbox_nonce'])) {
			return;
		}

		// Verify the nonce.
		if (!wp_verify_nonce($_POST['web_stories_checkbox_nonce'], 'web_stories_checkbox_nonce_action')) {
			return;
		}

		// Check if this is an autosave.
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// Check the user's permissions.
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}

		// Save or delete the checkbox value.
		$checkbox_value = isset($_POST['show_on_web_stories']) ? '1' : '0';
		update_post_meta($post_id, '_show_on_web_stories', $checkbox_value);
	}


	// Add a custom meta box to the post edit screen
		public function add_custom_meta_box() {
			add_meta_box(
				'custom_meta_box_id',
				'Select Number of Stories',
				'render_custom_meta_box',
				'post', // Change to your post type if needed
				'side' // Position: 'side', 'normal', or 'advanced'
			);

			// Render the select field
			function render_custom_meta_box($post) {
				wp_nonce_field('custom_meta_box_nonce', 'custom_meta_box_nonce');

				// Retrieve current value
				$stories_value = get_post_meta($post->ID, '_number_of_stories', true);
				?>
				<label for="number_of_stories">Select number of stories (1-10):</label>
				<select name="number_of_stories" id="number_of_stories">
					<?php for ($i = 1; $i <= 10; $i++): ?>
						<option value="<?php echo $i; ?>" <?php selected($stories_value, $i); ?>><?php echo $i; ?></option>
					<?php endfor; ?>
				</select>
				<?php
			}
		}

		// Save the number of stories value when the post is saved

		public function save_custom_meta_box($post_id) {
			// Check nonce
			if (!isset($_POST['custom_meta_box_nonce']) || !wp_verify_nonce($_POST['custom_meta_box_nonce'], 'custom_meta_box_nonce')) {
				return;
			}

			// Check if the user has permissions to save data
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}

			// Save the number of stories value
			if (isset($_POST['number_of_stories']) && is_numeric($_POST['number_of_stories'])) {
				$stories_value = intval($_POST['number_of_stories']);
				if ($stories_value >= 1 && $stories_value <= 10) {
					update_post_meta($post_id, '_number_of_stories', $stories_value);
				}
			}
		}

		// Save links in one table --------------------------

		public function save_webstorie_link($post_id) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'webstorie_links';
		
			// Prevent auto-save from triggering the function
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}
		
			// Check user permissions
			if (!current_user_can('edit_post', $post_id)) {
				return;
			}
		
			// Check if it's a valid post type and is being published
			if (get_post_type($post_id) === 'post') {
				// Only generate the link for published posts or when restoring from trash
				if (get_post_status($post_id) === 'publish' || get_post_status($post_id) === 'draft') {
					// Check if the meta box _show_on_web_stories is checked
					$show_on_web_stories = get_post_meta($post_id, '_show_on_web_stories', true);
		
					if ($show_on_web_stories) {
						// Generate the dynamic link
						$link = home_url("/wp-content/plugins/blog-web-stories/story-view.php?post_id=$post_id");
		
						// Check if the link already exists in the table
						$existing_link = $wpdb->get_var($wpdb->prepare("SELECT id FROM $table_name WHERE post_id = %d", $post_id));
		
						if ($existing_link) {
							// Update the existing link
							$updated = $wpdb->update(
								$table_name,
								array('link' => $link),
								array('post_id' => $post_id)
							);
		
							if ($updated === false) {
								error_log('Update failed: ' . $wpdb->last_error);
							}
						} else {
							// Insert the new link
							$inserted = $wpdb->insert(
								$table_name,
								array(
									'post_id' => $post_id,
									'link' => $link,
								)
							);
		
							if ($inserted === false) {
								error_log('Insert failed: ' . $wpdb->last_error);
							}
						}
					}
				}
			}
		}
		
		
		// Delete Link ----------------------------

		public function delete_webstorie_link($post_id) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'webstorie_links';
		
			// Check if the post type is 'post' before proceeding
			if (get_post_type($post_id) === 'post') {
				// Delete the link associated with the post_id
				$deleted = $wpdb->delete(
					$table_name,
					array('post_id' => $post_id)
				);
		
				if ($deleted === false) {
					error_log('Delete failed: ' . $wpdb->last_error);
				}
			}
		}

// ---------------------------------------	SiteMap ---------------------------------------

		public function my_custom_sitemap() {
			if (isset($_GET['sitemap'])) {
				header('Content-Type: application/xml; charset=utf-8');
				echo $this->my_generate_sitemap(); // Use $this-> to access the method
				exit;
			}
		}
		
		public function my_generate_sitemap_old() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'webstorie_links';
		
			// Fetch web story links from the custom table
			$web_stories = $wpdb->get_results("SELECT post_id, link FROM $table_name");
		
			$urls = [];
			foreach ($web_stories as $story) {
				$post_modified = get_post_modified_time('Y-m-d', false, $story->post_id);
				
				$urls[] = [
					'loc' => esc_url($story->link),
					'lastmod' => esc_html($post_modified),
					'changefreq' => 'daily',
					'priority' => '0.8'
				];
			}
		
			// Generate the XML for the sitemap
			$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
			$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap-image/1.1"';
			$sitemap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
			$sitemap .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap-image/1.1 http://www.sitemaps.org/schemas/sitemap-image/1.1/sitemap-image.xsd">';
			
			foreach ($urls as $url) {
				$sitemap .= '<url>';
				$sitemap .= '<loc>' . esc_url($url['loc']) . '</loc>';
				$sitemap .= '<lastmod>' . esc_html($url['lastmod']) . '</lastmod>';
				$sitemap .= '<changefreq>' . esc_html($url['changefreq']) . '</changefreq>';
				$sitemap .= '<priority>' . esc_html($url['priority']) . '</priority>';
				$sitemap .= '</url>';
			}
		
			$sitemap .= '</urlset>';
			return $sitemap;
		}

		public function my_generate_sitemap_oldd() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'webstorie_links';
		
			// Fetch web story links from the custom table
			$web_stories = $wpdb->get_results("SELECT post_id, link FROM $table_name");
		
			$urls = [];
			foreach ($web_stories as $story) {
				$post_modified = get_post_modified_time('Y-m-d', false, $story->post_id);
				
				$urls[] = [
					'loc' => esc_url($story->link),
					'lastmod' => esc_html($post_modified),
					'changefreq' => 'daily',
					'priority' => '0.8'
				];
			}
		
			// Generate the XML for the sitemap
			$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
			// Use the standard sitemap namespace
			$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
			$sitemap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
			$sitemap .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		
			foreach ($urls as $url) {
				$sitemap .= '<url>';
				$sitemap .= '<loc>' . esc_url($url['loc']) . '</loc>';
				$sitemap .= '<lastmod>' . esc_html($url['lastmod']) . '</lastmod>';
				$sitemap .= '<changefreq>' . esc_html($url['changefreq']) . '</changefreq>';
				$sitemap .= '<priority>' . esc_html($url['priority']) . '</priority>';
				$sitemap .= '</url>';
			}
		
			$sitemap .= '</urlset>';
			return $sitemap;
		}

		public function my_generate_sitemap() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'webstorie_links';
		
			// Fetch post IDs with the _show_on_web_stories meta key set to true
			$post_ids = $wpdb->get_col("
				SELECT post_id 
				FROM $wpdb->postmeta 
				WHERE meta_key = '_show_on_web_stories' 
				AND meta_value = '1'
			");
		
			// Fetch web story links from the custom table for the selected post IDs
			$web_stories = $wpdb->get_results(
				$wpdb->prepare("SELECT post_id, link FROM $table_name WHERE post_id IN (" . implode(',', array_fill(0, count($post_ids), '%d')) . ")", $post_ids)
			);
		
			$urls = [];
			foreach ($web_stories as $story) {
				$post_modified = get_post_modified_time('Y-m-d', false, $story->post_id);
				
				$urls[] = [
					'loc' => esc_url($story->link),
					'lastmod' => esc_html($post_modified),
					'changefreq' => 'daily',
					'priority' => '0.8'
				];
			}
		
			// Generate the XML for the sitemap
			$sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
			$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"';
			$sitemap .= ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"';
			$sitemap .= ' xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
		
			foreach ($urls as $url) {
				$sitemap .= '<url>';
				$sitemap .= '<loc>' . esc_url($url['loc']) . '</loc>';
				$sitemap .= '<lastmod>' . esc_html($url['lastmod']) . '</lastmod>';
				$sitemap .= '<changefreq>' . esc_html($url['changefreq']) . '</changefreq>';
				$sitemap .= '<priority>' . esc_html($url['priority']) . '</priority>';
				$sitemap .= '</url>';
			}
		
			$sitemap .= '</urlset>';
			return $sitemap;
		}


// 04-11-2024 ----------------------------------------

	public function cws_generate_web_story_old($post_id) {
		// Only run on specific post types (e.g., 'post')
		if (get_post_type($post_id) != 'post') {
			return;
		}

		// Get post content
		$post = get_post($post_id);
		$title = get_the_title($post);
		$content = apply_filters('the_content', $post->post_content);
		$content_parts = explode("\n\n", $content); // Split content into paragraphs

		// Start building HTML
		ob_start(); ?>
		<!doctype html>
		<html ⚡>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
			<link rel="canonical" href="https://example.com/canonical-url">
			<title><?php echo esc_html($title); ?></title>
			<style amp-custom>
				/* Add any custom styles here */
			</style>
			<style amp-boilerplate>
				body {
					-webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					-moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					-ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					animation: -amp-start 8s steps(1, end) 0s 1 normal both;
				}

				@-webkit-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}

				@-moz-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}

				@-ms-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}

				@keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}
			</style>
			<noscript>
				<style amp-boilerplate>
					body {
						-webkit-animation: none;
						-moz-animation: none;
						-ms-animation: none;
						animation: none;
					}
				</style>
			</noscript>
		</head>
		<body>
			<amp-story 
				standalone 
				poster-portrait-src="https://example.com/poster.jpg" 
				publisher="Your Publisher Name" 
				publisher-logo-src="https://example.com/logo.png" 
				title="Sample Story Title">
				
				<?php foreach ($content_parts as $index => $part): ?>
					<amp-story-page id="page-<?php echo $index + 1; ?>">
						<amp-story-grid-layer template="fill">
							<amp-img src="https://example.com/image<?php echo $index + 1; ?>.jpg" layout="fill" alt="Image Description"></amp-img>
						</amp-story-grid-layer>
						<amp-story-grid-layer template="vertical">
							<h1><?php echo esc_html($title); ?></h1>
							<p><?php echo esc_html($part); ?></p>
						</amp-story-grid-layer>
					</amp-story-page>
				<?php endforeach; ?>
			</amp-story>
		</body>
		</html>


		<?php

		// Output the generated HTML
		$html_output = ob_get_clean();
		
		// Save the output as a file (you can customize the filename and path)
		$file_path = plugin_dir_path(__FILE__) . 'stories/' . sanitize_title($title) . '.html';
		if (!file_exists(plugin_dir_path(__FILE__) . 'stories/')) {
			mkdir(plugin_dir_path(__FILE__) . 'stories/', 0755, true);
		}
		file_put_contents($file_path, $html_output);
		
		// Optionally, you can return the path to the generated file
		return $file_path;
	}


	public function cws_generate_web_story($post_id) {
		// Only run on specific post types (e.g., 'post')
		if (get_post_type($post_id) != 'post') {
			return;
		}
	
		// Get post content
		$post = get_post($post_id);
		$title = get_the_title($post);
		$content = apply_filters('the_content', $post->post_content);
		$content_parts = explode("\n\n", $content); // Split content into paragraphs
	
		// Start building HTML
		ob_start(); ?>
		<!doctype html>
		<html ⚡>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
			<link rel="canonical" href="https://example.com/canonical-url">
			<title><?php echo esc_html($title); ?></title>
			<style amp-custom>
				/* Add any custom styles here */
			</style>
			<style amp-boilerplate>
				body {
					-webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					-moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					-ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
					animation: -amp-start 8s steps(1, end) 0s 1 normal both;
				}
	
				@-webkit-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}
	
				@-moz-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}
	
				@-ms-keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}
	
				@keyframes -amp-start {
					from { visibility: hidden; }
					to { visibility: visible; }
				}
			</style>
			<noscript>
				<style amp-boilerplate>
					body {
						-webkit-animation: none;
						-moz-animation: none;
						-ms-animation: none;
						animation: none;
					}
				</style>
			</noscript>
		</head>
		<body>
			<amp-story 
				standalone 
				poster-portrait-src="https://example.com/poster.jpg" 
				publisher="Your Publisher Name" 
				publisher-logo-src="https://example.com/logo.png" 
				title="<?php echo esc_html($title); ?>">
				
				<?php foreach ($content_parts as $index => $part): ?>
					<amp-story-page id="page-<?php echo $index + 1; ?>">
						<amp-story-grid-layer template="fill">
							<amp-img src="https://example.com/image<?php echo $index + 1; ?>.jpg" layout="fill" alt="Image Description"></amp-img>
						</amp-story-grid-layer>
						<amp-story-grid-layer template="vertical">
							<h1><?php echo esc_html($title); ?></h1>
							<p><?php echo esc_html(trim($part)); ?></p>
						</amp-story-grid-layer>
					</amp-story-page>
				<?php endforeach; ?>
			</amp-story>
		</body>
		</html>
		<?php
	
		// Output the generated HTML
		$html_output = ob_get_clean();
	
		// Define file path
		$stories_dir = plugin_dir_path(__FILE__) . 'stories/';
		$file_path = $stories_dir . sanitize_title($title) . '.html';
	
		// Check if the directory exists, if not, create it
		if (!is_dir($stories_dir)) {
			if (mkdir($stories_dir, 0755, true)) {
				error_log("Directory created: " . $stories_dir);
			} else {
				error_log("Failed to create directory: " . $stories_dir);
				return; // Stop execution if directory creation fails
			}
		}
	
		// Write HTML to file
		if (file_put_contents($file_path, $html_output) === false) {
			error_log("Failed to write file: " . $file_path);
		}
	
		// Optionally, return the path to the generated file
		return $file_path;
	}


	// ---- indexing  ---- 

	// public function auto_index_google($post_id) {
	// 	if (get_post_type($post_id) == 'post' && get_post_status($post_id) == 'publish') {
	// 		$post_url = get_permalink($post_id);
			
	// 		$url = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
			
	// 		$headers = [
	// 			'Content-Type' => 'application/json',
	// 			'Authorization' => 'Bearer ' . $this->get_google_access_token(),
	// 		];
			
	// 		$body = json_encode([
	// 			'url' => $post_url,
	// 			'type' => 'URL_UPDATED'
	// 		]);
			
	// 		$response = wp_remote_post($url, [
	// 			'headers' => $headers,
	// 			'body'    => $body,
	// 		]);
			
	// 		if (is_wp_error($response)) {
	// 			error_log('Error indexing URL: ' . $response->get_error_message());
	// 		}
	// 	}
	// }
		
	// public function get_google_access_token() {
	// 	$client_id = 'YOUR_CLIENT_ID'; // Replace with your Client ID
	// 	$client_secret = 'YOUR_CLIENT_SECRET'; // Replace with your Client Secret
	// 	$refresh_token = 'YOUR_REFRESH_TOKEN'; // Replace with your Refresh Token
	
	// 	$token_url = 'https://oauth2.googleapis.com/token';
	
	// 	$response = wp_remote_post($token_url, [
	// 		'body' => [
	// 			'client_id' => $client_id,
	// 			'client_secret' => $client_secret,
	// 			'refresh_token' => $refresh_token,
	// 			'grant_type' => 'refresh_token',
	// 		],
	// 	]);
	
	// 	if (is_wp_error($response)) {
	// 		error_log('Error getting access token: ' . $response->get_error_message());
	// 		return ''; // Handle the error accordingly
	// 	}
	
	// 	$body = json_decode(wp_remote_retrieve_body($response), true);
		
	// 	return isset($body['access_token']) ? $body['access_token'] : '';
	// }

}
