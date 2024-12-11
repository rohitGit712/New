<!DOCTYPE html>
<html ⚡ lang="en">
<?php 
// Include WordPress functionality
require_once('../../../wp-load.php');

// Get the post ID from the URL
$post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;

if ($post_id) {
    $post = get_post($post_id);
    if ($post) {
        setup_postdata($post);

        // Use a regular expression to find all image URLs
        preg_match_all('/<img[^>]+src="([^">]+)"/', $post->post_content, $matches);

        // $matches[1] contains all the image URLs
        $images = $matches[1];

        // Extract headings (h2-h6)
        preg_match_all('/<h[2-6][^>]*>(.*?)<\/h[2-6]>/', $post->post_content, $headings);
        $headings = $headings[1]; // Extract headings

        // Extract and format paragraphs
        preg_match_all('/<p>(.*?)<\/p>/', $post->post_content, $paragraphs);
        $paragraphs = array_map('wpautop', $paragraphs[1]); // Format paragraphs

        // Get all images attached to the post
        // $images = get_attached_media('image', $post_id);
        
        // Determine the maximum number of pages based on available content (headings, paragraphs, images)
        $max_pages = max(count($images), count($headings), count($paragraphs));

        $favicon_url_id = get_theme_mod('custom_logo'); // Fetch site logo ID (if used as favicon)
        $favicon_url = $favicon_url_id ? wp_get_attachment_image_url($favicon_url_id, 'full') : get_site_icon_url();
		// Output the favicon
        
        ?>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            
            <!-- SEO Meta Tags -->
            <meta name="description" content="<?php echo get_the_excerpt($post_id); ?>">
            <meta name="robots" content="index, follow">
            <meta property="og:type" content="article">
            <meta property="og:title" content="<?php echo the_title(); ?>">
            <meta property="og:description" content="<?php echo get_the_excerpt($post_id); ?>">
            <meta property="og:url" content="<?php echo get_permalink($post_id); ?>">
            <meta property="og:image" content="<?php echo get_the_post_thumbnail_url($post_id); ?>">
            <meta name="twitter:card" content="summary_large_image">
            <meta name="twitter:title" content="<?php echo the_title(); ?>">
            <meta name="twitter:description" content="<?php echo get_the_excerpt($post_id); ?>">
            <meta name="twitter:image" content="<?php echo get_the_post_thumbnail_url($post_id); ?>">
            <link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon_url); ?>">


            <!-- Canonical Tag -->
            <?php
            $current_url = esc_url(plugins_url('/story-view.php', __FILE__)) . '?post_id=' . $post_id; // Build the current URL with query params

            // Use the appropriate canonical URL
            ?>

            <link rel="canonical" href="<?php echo $current_url; ?>">



            <!-- AMP Boilerplate Styles (required) -->
            <style amp-boilerplate> 
                body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}
            </style>
            <noscript>
                <style amp-boilerplate>
                    body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}
                </style>
            </noscript>

            <!-- AMP Required Scripts -->
            <script async src="https://cdn.ampproject.org/v0.js"></script>
            <script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
            <!-- <script async custom-element="amp-animation" src="https://cdn.ampproject.org/v0/amp-animation-0.1.js"></script> -->

            <!-- Custom Styles for AMP -->

            <style amp-custom>
				body {
					margin: 0;
					font-family: 'Helvetica Neue', Arial, sans-serif;
					background-color: #121212;
					color: #fff;
				}

				amp-story {
					background-color: #121212;
					color: #fff;
				}

				amp-story-grid-layer p {
					text-align: center;
					border-radius: 10px;
					padding: 5px;
					font-size: 15px;
				}

				/* Styling the main title on the first page */
				.main-title {
					font-size: 45px;
					text-align: center;
					color: #FFCC00;
					margin-top: 20px;
					text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
				}

				/* Intro text styling */
				.intro-text {
					margin-top: 10px;
					color: #ddd;
					line-height: 1.5;
					text-align: center;
					border-radius: 10px;
					font-size: 13px;
					margin-top: 0px;
					padding: 10px 20px;
				}

				/* Image styling */
				/* .story-image {
					border-radius: 15px;
					box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.4);
					transition: transform 0.5s ease;
					height: 60%;
					margin-top: 0%;
					object-fit: cover;
					max-height: 300px;
					height: 230px;
				} */

                .story-image {
                    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.4);
                    transition: transform 0.5s ease;
                    height: 60%;
                    margin-top: 0%;
                    object-fit: cover;
                    max-height: 300px;
                    height: 230px;
                    border-radius: 30px;
                }

                .mainImg {
                    position: relative;
                }

                .logoImg {
                    position: absolute;
                    bottom: -60px;
                    width: 100%;
                }

                #page-1 .story-image {
                    border-radius: 0;
                    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.4);
                    transition: transform 0.5s ease;
                    height: 60%;
                    margin-top: 0;
                    object-fit: cover;
                    max-height: 320px;
                    height: 320px;
                    border-radius: 30px 30px 30px 30px;
                }

                amp-story-page#page-1 h1 {
                    font-size: 29px;
                    padding-top: 20px;
                }

				/* Image hover effect */
				.story-image:hover {
					transform: scale(1.05);
				}

				/* Page heading */
				.story-heading {
					font-size: 26px;
					color: white;
					text-align: center;
					text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
				}

				/* Story text styling */
				.story-text {
					font-size: 18px;
					text-align: center;
					margin-top: 0px;
					padding: 10px 20px;
					color: #ddd;
					line-height: 1.6;
                    font-weight: bold;
				}

				/* Page transitions */
				amp-story-page {
					background-color: black;
					transition: transform 0.6s ease, opacity 0.6s ease;
				}

				/* Adjust page layout and spacing */
				#page-1 amp-story-grid-layer {
					padding: 20px;
					padding-top: 50px;
				}

                amp-story-grid-layer {
					padding: 20px;
					padding-top: 0px;
				}

                #latest-posts amp-story-grid-layer {
					padding: 0px;
					padding-top: 0px;
                    grid-gap: 40px;
				}
                

				/* Optional Close button */
				.close-button {
					position: absolute;
					top: 20px;
					right: 20px;
					font-size: 24px;
					color: #fff;
					text-decoration: none;
					background-color: rgba(0, 0, 0, 0.7);
					border-radius: 50%;
					padding: 10px;
				}

				/* Add a smooth transition for page content */
				.story-text, .story-heading {
					opacity: 0;
					/* transition: opacity 0.5s ease-in-out; */
				}

				amp-story-page[active] .story-text,
				amp-story-page[active] .story-heading {
					opacity: 1;
				}

				amp-story-grid-layer {
					grid-gap: 17px;
				}


                /* new css last page */

                amp-story-page#latest-posts h2 {
                    padding-top: 40px;
                }

                .latest-post-item amp-img {
                    border-radius: 30px;
                    width: 64%;
                    margin: auto;
                    height: 130px;
                }

                h3.latest-post-title {
                    text-align: center;
                    padding-top: 15px;
                }

                a.latest-post-link {
                    text-align: center;
                    background: white;
                    color: black;
                    padding: 20px;
                }

                a.latest-post-link p {
                    font-weight: bold;
                    font-size: 20px;
                }

                .mainImg .story-image {
                    border: none;
                }

                .logoImg amp-img {
                    border: 5px solid white;
                    border-radius: 13px;
                }


                @media (min-width: 320px) and (max-width: 768px) {
                    a.latest-post-link {
                        text-align: center;
                        background: white;
                        color: black;
                        padding: 20px;
                        position: absolute;
                        bottom: 0em;
                    }    
                    .latest-post-item amp-img {
                        border-radius: 30px;
                        width: 75%;
                        margin: auto;
                        height: 140px;
                    }
                    #latest-posts amp-story-grid-layer {
                        padding: 0px;
                        padding-top: 100px;
                        grid-gap: 40px;
                    }
                    
                    .layarGrid {
                        margin-top: 100px;
                    }

                }

                @media (min-width: 768px) and (max-width: 1050px) {
                    a.latest-post-link {
                        text-align: center;
                        background: white;
                        color: black;
                        padding: 20px;
                        position: absolute;
                        bottom: 0em;
                    }

                    #latest-posts amp-story-grid-layer {
                        padding: 0px;
                        padding-top: 0px;
                        grid-gap: 40px;
                    }
                }

                a.latest-post-link {
                        text-align: center;
                        background: white;
                        color: black;
                        padding: 20px;
                        position: absolute;
                        bottom: 0em;
                }

                .layarGrid {
                    padding-top: 60px;
                }

			</style>

            <title><?php echo get_the_title($post_id); ?> | My Website Name</title>

            <!-- Live Story Meta (for real-time updates) -->
            <meta property="og:updated_time" content="<?php echo get_the_modified_time('c', $post_id); ?>">
            <meta property="og:live" content="true">
            <meta property="og:live-status" content="live">
            <meta property="og:live-url" content="<?php echo get_permalink($post_id); ?>">
            
            <!-- Add structured data for SEO -->
            <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              "@type": "Article",
              "headline": "<?php echo the_title(); ?>",
              "description": "<?php echo get_the_excerpt($post_id); ?>",
              "image": "<?php echo get_the_post_thumbnail_url($post_id); ?>",
              "url": "<?php echo get_permalink($post_id); ?>",
              "publisher": {
                "@type": "Organization",
                "name": "My Website Name",
                "logo": {
                  "@type": "ImageObject",
                  "url": "https://example.com/logo.png"
                }
              },
              "author": {
                "@type": "Person",
                "name": "<?php echo get_the_author(); ?>"
              },
              "datePublished": "<?php echo get_the_date('c', $post_id); ?>",
              "dateModified": "<?php echo get_the_modified_date('c', $post_id); ?>"
            }
            </script>
        </head>
        <body>
        
        <!-- AMP Story Block -->
        <amp-story standalone title="<?php echo the_title(); ?>" publisher="My Website" publisher-logo-src="https://wp.stories.google/stories/tips-web-stories-editor/assets/Logo-web-stories-circle-1.png" poster-portrait-src="<?php echo get_the_post_thumbnail_url($post_id); ?>">

            <!-- First Page (Main Title and Featured Image) -->
            <amp-story-page id="page-1">
                <amp-story-grid-layer template="vertical" style="grid-gap: 30px;">
                    <!-- Display post thumbnail (first image) -->
                    <div class='mainImg'>
                        <amp-img src="<?php echo esc_url(get_the_post_thumbnail_url($post_id)); ?>"
                            width="900" height="1600" layout="responsive"
                            alt="Post Image" object-position="center" class="story-image"></amp-img>

                        <!-- Display the site logo -->
                        <?php
                        $custom_logo_id = get_theme_mod('custom_logo');
                        $custom_logo_url = $custom_logo_id ? wp_get_attachment_image_url($custom_logo_id, 'full') : '';
                        ?>
                        <div class="logoImg">
                            <amp-img 
                                src="<?php echo esc_url($custom_logo_url ? $custom_logo_url : 'https://wp.stories.google/stories/tips-web-stories-editor/assets/Logo-web-stories-circle-1.png'); ?>" 
                                width="100" height="100" layout="fixed"
                                alt="Site Logo" class="site-logo" style="margin: 20px auto; display: block;">
                            </amp-img>
                        </div>
                    </div>

                    <!-- Title of the page -->
                    <h1 class="main-title" style="font-size: 32px; color: white; text-align: center;">
                        <?php echo get_the_title($post_id); ?>
                    </h1>
                </amp-story-grid-layer>

                <!-- Swipe-up attachment for Learn More -->
                <amp-story-page-attachment layout="nodisplay" href="<?php echo esc_url(get_permalink($post_id)); ?>" cta-text="Continue Reading Here">
                </amp-story-page-attachment>


            </amp-story-page>

            <?php
                $number_of_stories = get_post_meta($post_id, '_number_of_stories', true);

                // Convert to an integer
                $number_of_stories = intval($number_of_stories);

                // Ensure the number of stories is between 1 and 10
                if ($number_of_stories >= 1 && $number_of_stories <= 10) {
                    for ($n = 0; $n < $number_of_stories - 1; $n++) {
                        if (count($images) <= $n) {
                            break; // Break the loop if there are not enough images
                        }

                        // Cache content once to avoid repeated isset and strip_tags checks
                        $image = isset($images[$n]) ? esc_url($images[$n]) : null;
                        $heading = isset($headings[$n]) ? $headings[$n] : 'No Heading';
                        $content = isset($paragraphs[$n + 1]) ? strip_tags($paragraphs[$n + 1], '<strong><em><b><i><a>') : 'No content available.';
                        
                        // Alternate layout based on iteration (even vs odd)
                        $is_even = ($n % 2 === 0);
                        
                        ?>
                        <amp-story-page id="page-<?php echo $n + 2; ?>">
                            <amp-story-grid-layer template="vertical" class="layarGrid">
                                <?php if ($is_even): ?>
                                    <!-- Even iteration: Image first, then title and description -->
                                    <?php if ($image): ?>
                                        <amp-img src="<?php echo $image; ?>"
                                            width="900" height="1600" layout="responsive"
                                            alt="Post Image" class="story-image"
                                            animate-in="fly-in-left"
                                            animate-in-duration="1s"
                                        ></amp-img>
                                    <?php endif; ?>

                                    <h2 class="story-heading" style="padding-top: 20px;"><?php echo $heading; ?></h2>
                                    <p class="story-text">
                                        <?php 
                                            $outContent = substr($content, 0, 180);
                                            if (strlen($content) > 180) {
                                                $outContent .= '...';
                                            }
                                            echo $outContent;
                                        ?>
                                    </p>

                                <?php else: ?>
                                    <!-- Odd iteration: Title and description first, then image -->
                                    <h2 class="story-heading"><?php echo $heading; ?></h2>
                                    <p class="story-text">
                                        <?php 
                                            $outContent = substr($content, 0, 180);
                                            if (strlen($content) > 180) {
                                                $outContent .= '...';
                                            }
                                            echo $outContent;
                                        ?>
                                    </p>
                                    <?php if ($image): ?>
                                        <amp-img src="<?php echo $image; ?>"
                                            width="900" height="1600" layout="responsive"
                                            alt="Post Image" class="story-image"
                                            animate-in="fly-in-right"
                                            animate-in-duration="1s">
                                        </amp-img>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </amp-story-grid-layer>

                            <!-- Sticky "Learn More" Button -->
                            <amp-story-page-attachment layout="nodisplay" href="<?php echo esc_url(get_permalink($post_id)); ?>" cta-text="Continue Reading Here">
                            </amp-story-page-attachment>

                        </amp-story-page>
                        <?php
                    }
                }

            // Fetch the two latest posts by date
            $latest_posts = get_posts([
                'numberposts' => 2,
                'orderby' => 'date',
                'order' => 'DESC',
            ]);

            if (!empty($latest_posts)) {
                ?>
                <amp-story-page id="latest-posts" style="padding: 0;">
                    <amp-story-grid-layer template="vertical">
                        <h2 class="latest-posts-title" style="font-size: 41px; color: white; text-align: center;">MORE POSTS</h2>
                        
                        <div class="latest-posts-container" style="display: flex; flex-direction: column; gap: 0px; justify-content: space-between;">
                            <?php foreach ($latest_posts as $post): ?>
                                <div class="latest-post-item" style="padding: 10px; background: #000000aa;">
                                    <!-- Display Post Thumbnail -->
                                    <?php if (has_post_thumbnail($post->ID)): ?>
                                        <amp-img 
                                            src="<?php echo esc_url(get_the_post_thumbnail_url($post->ID, 'medium')); ?>" 
                                            width="300" height="200" layout="responsive" 
                                            alt="<?php echo esc_attr(get_the_title($post->ID)); ?>" 
                                            style="margin-bottom: 8px;"
                                            animate-in="fade-in"
                                            animate-in-duration="2s"></amp-img>
                                    <?php endif; ?>

                                    <!-- Display Post Title -->
                                    <h3 class="latest-post-title" style="font-size: 18px; color: white; cursor: pointer;" animate-in="fade-in"
                                    animate-in-duration="2s">
                                        <a href="<?php echo esc_url(get_permalink($post->ID)); ?>" 
                                        style="color: white; text-decoration: none;">
                                            <?php echo esc_html(get_the_title($post->ID)); ?>
                                        </a>
                                    </h3>

                                </div>

                            <?php endforeach; ?>

                            <!-- Footer link at the bottom -->
                            <a href="<?php echo esc_url(home_url()); ?>" 
                                class="latest-post-link" 
                                style="text-decoration:none; cursor: pointer;">
                                <p animate-in="fly-in-left" animate-in-duration="2s">
                                    For more posts like this, visit <?php echo parse_url(home_url(), PHP_URL_HOST); ?>
                                </p>
                            </a>
                        </div>
                    </amp-story-grid-layer>
                </amp-story-page>

                <?php
                    }
                ?>

        </amp-story>

        <?php
        wp_reset_postdata();
    } else {
        echo '<p>Post not found.</p>';
    }
} else {
    echo '<p>No post specified.</p>';
}
?>

</body>
</html>