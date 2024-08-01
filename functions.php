<?php
/**
 * UDeals functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package UDeals
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function udeals_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on UDeals, use a find and replace
		* to change 'udeals' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'udeals', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'udeals' ),
			'top-bar-menu' => esc_html__( 'Top Bar Menu', 'udeals' ),
			'footer-1' => esc_html__( 'Footer Menu 1', 'udeals' ),
			'footer-2' => esc_html__( 'Footer Menu 2', 'udeals' ),
			'footer-3' => esc_html__( 'Footer Menu 3', 'udeals' ),
			'footer-bar' => esc_html__( 'Footer Bar', 'udeals' )
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'udeals_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'udeals_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function udeals_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'udeals_content_width', 640 );
}
add_action( 'after_setup_theme', 'udeals_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function udeals_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'udeals' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'udeals' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'udeals_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function udeals_scripts() {
	wp_enqueue_style( 'udeals-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'udeals-style', 'rtl', 'replace' );

	wp_enqueue_script( 'udeals-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'udeals_js', get_template_directory_uri() . '/js/udeals.js', array(), _S_VERSION, true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'udeals_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Adds WooCommerce support to the theme.
 *
 * This function adds support for WooCommerce to the current theme by using the `add_theme_support` function.
 * It is hooked to the `after_setup_theme` action, which ensures that WooCommerce support is added after the theme is setup.
 */
function udeals_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'udeals_add_woocommerce_support' );

/**
 * Customize the title of WooCommerce products on the shop page or product archives.
 *
 * @param string $title The original title of the product.
 * @param int $id The ID of the product.
 * @return string The modified title of the product.
 */
add_filter( 'the_title', 'customize_woocommerce_product_title', 10, 2 );
function customize_woocommerce_product_title( $title, $id ) {
    // Only apply to WooCommerce products on the shop page or product archives
    if ( ( is_shop() || is_product_category() || is_product_tag() ) && get_post_type( $id ) === 'product' ) {
        if ( strlen( $title ) > 50 ) {
            $title = substr( $title, 0, 50 ) . '...';
        }
    }
    return $title;
}

/**
 * Custom function to display WooCommerce star rating.
 *
 * This function outputs the star rating HTML for a product based on its average rating and review count.
 *
 * @global WC_Product $product The current product object.
 */
function custom_woocommerce_star_rating() {
    global $product;
    $average = $product->get_average_rating();
    $review_count = $product->get_review_count();

    // Output the rating HTML
    echo '<div class="star-rating">';
		if ($review_count > 0) {
			if($average > 0) {
				echo '<span class="avg-rating">' . $average . '</span>';
			}
			for ($i = 1; $i <= 5; $i++) {
				if ($average >= $i) {
					// echo '<span class="star filled">&#9733;</span>';'img/icons/FullStar_36px-Gold.svg'
					echo '<img src="' . get_template_directory_uri() . '/img/icons/FullStar_36px-Gold.svg" alt="star-filled" class="star filled">';
				} elseif ($average > $i - 1) {
					// Display half-star if average is between star values
					// echo '<span class="star half-filled">&#9733;</span>';
					echo '<img src="' . get_template_directory_uri() . '/img/icons/HalfStar_36px-Gold.svg" alt="star-filled" class="star filled">';
				} else {
					// echo '<span class="star">&#9734;</span>'; 
					echo '<img src="' . get_template_directory_uri() . '/img/icons/Star_36px-Gold.svg" alt="star-filled" class="star filled">';
				}
			}
			// Modify this line to include the average rating
			
				echo '<span class="rating-count">' . $review_count . ' ratings</span>';
		}
    echo '</div>';
}

function custom_woocommerce_get_rating_html($rating_html, $rating, $count) {
    if ( $rating > 0 ) {
        // Start building the rating HTML
        $html  = '<div class="star-rating" title="' . sprintf( __( 'Rated %s out of 5', 'woocommerce' ), $rating ) . '">';
        $html .= '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%">';
        for ($i = 1; $i <= 5; $i++) {
            if ($rating >= $i) {
                $html .= '<span class="star filled">&#9733;</span>'; // Gold star
            } elseif ($rating > $i - 1) {
                $html .= '<span class="star half-filled">&#9733;</span>'; // For half stars, if needed
            } else {
                $html .= '<span class="star">&#9733;</span>'; // Grey star
            }
        }
        $html .= '</span></div>';

        return $html;
    }

    return ''; // Return empty string if no rating
}
add_filter('woocommerce_product_get_rating_html', 'custom_woocommerce_get_rating_html', 10, 3);

// Remove default WooCommerce rating from shop loop
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
// Add custom rating to shop loop
add_action('woocommerce_after_shop_loop_item_title', 'custom_woocommerce_star_rating', 5);

// Remove default WooCommerce rating from product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);

add_filter('woocommerce_sale_flash', 'custom_variable_sale_flash', 10, 3);
function custom_variable_sale_flash($html, $post, $product) {
    // Check if the product is a variable product
    if ($product->is_type('variable')) {
        $max_discount = 0;

        // Loop through all variations of the product
        $variations = $product->get_available_variations();
        foreach ($variations as $variation) {
            $variation_obj = wc_get_product($variation['variation_id']);
            if ($variation_obj->get_regular_price() && $variation_obj->get_sale_price()) {
                $regular_price = (float) $variation_obj->get_regular_price();
                $sale_price = (float) $variation_obj->get_sale_price();
                $discount = (($regular_price - $sale_price) / $regular_price) * 100;
                if ($discount > $max_discount) {
                    $max_discount = $discount;
                }
            }
        }

        // If there's at least one variation on sale, show the "UPTO X% OFF" badge
        if ($max_discount > 0) {
            $max_discount_rounded = round($max_discount, 0);
            return '<span class="onsale">UPTO ' . $max_discount_rounded . '% OFF</span>';
        }
    }
    // For non-variable products or if no variations are on sale, return the default sale flash HTML
    else if ($product->get_regular_price() && $product->get_sale_price()) {
        $regular_price = (float) $product->get_regular_price();
        $sale_price = (float) $product->get_sale_price();
        $percentage = round(((($regular_price - $sale_price) / $regular_price) * 100), 0);
        return '<span class="onsale">' . $percentage . '% OFF</span>';
    }

    return $html;
}

/**
 * Removes the page title on the WooCommerce shop page.
 *
 * @param string $title The current page title.
 * @return string|bool The modified page title or false if it's the shop page.
 */
add_filter( 'woocommerce_show_page_title' , 'custom_remove_shop_page_title' );
function custom_remove_shop_page_title( $title ) {
	if ( is_shop() || is_front_page() ) {
		return false;
	}
	return $title;
}

/**
 * Removes avatars from WooCommerce product reviews.
 *
 * This function is used as a filter for the 'get_avatar' hook. It checks if the current context is a WooCommerce product review and removes the avatar if it is. Otherwise, it returns the original avatar.
 *
 * @param string $avatar The HTML markup for the avatar.
 * @param mixed $id_or_email The user ID or email address.
 * @param int $size The avatar size in pixels.
 * @param string $default The default avatar URL.
 * @param string $alt The alternative text for the avatar.
 * @return string|null The modified avatar HTML markup or null if the avatar should be removed.
 */
add_filter('get_avatar', 'remove_review_avatars', 10, 5);
function remove_review_avatars($avatar, $id_or_email, $size, $default, $alt) {
    // Check if we're inside the WooCommerce product review context
    if (is_singular('product') && in_the_loop() && is_main_query()) {
        return null; // Return null to remove the avatar
    }

    return $avatar; // Return the original avatar in other contexts
}

add_filter( 'woocommerce_output_related_products_args', 'custom_related_products_args', 20 );
function custom_related_products_args( $args ) {
    $args['posts_per_page'] = 4; // Number of related products
    $args['columns'] = 4; // Number of columns
    return $args;
}

/**
 * Modifies the text displayed on the "Thank You" page after a successful order in WooCommerce.
 *
 * @param string $text The default text displayed on the "Thank You" page.
 * @param WC_Order $order The WooCommerce order object.
 * @return string The modified text to be displayed on the "Thank You" page.
 */
add_filter('woocommerce_thankyou_order_received_text', 'custom_thankyou_order_received_text', 10, 2);
function custom_thankyou_order_received_text($text, $order) {
	return 'We are going to process your order right away. You will receive an email confirmation with the order details and your shipping information. Thank you for shopping with UDeals!';
}

/**
 * Outputs the custom product summary.
 */
function custom_output_product_summary() {
	if (is_product()) {
		echo '<div class="summary_block summary_block--desktop">';
			echo '<div class="summary_block_inners">';

				// Output the title of the product.
				woocommerce_template_single_title(); // Product Title

				// Display the product rating, such as star ratings from customer reviews.
				custom_woocommerce_star_rating(); // Rating

				// Display the product price.
				woocommerce_template_single_price(); // Price

				// Show the product excerpt or description.
				woocommerce_template_single_excerpt(); // Excerpt or Description

				echo '<div class="custom_product_labels">';
					echo '<div class="custom_product_label"><img src="' . get_stylesheet_directory_uri() . '/img/icons/delivery.svg" alt="Free Delivery" /> Fast & Free Shipping</div>';
					echo '<div class="custom_product_label"><img src="' . get_stylesheet_directory_uri() . '/img/icons/safe.svg" alt="Safe payments" /> Safe & Secure Payment</div>';
					echo '<div class="custom_product_label"><img src="' . get_stylesheet_directory_uri() . '/img/icons/guarantee.svg" alt="Money back Guarantee" /> Money Back Guarantee</div>';
				echo "</div>";	

				// Add to Cart button.
				woocommerce_template_single_add_to_cart(); // Add to Cart button

				// Display meta information like categories and tags.
				//woocommerce_template_single_meta(); // Meta information

				// Social sharing buttons.
				woocommerce_template_single_sharing(); // Sharing buttons

			echo '</div>';
		echo '</div>';
	}
}

/**
 * Outputs the custom product summary for mobile devices.
 */
function custom_output_product_summary_mobile() {
	echo '<div class="summary_block--mobile">';
		echo '<div class="summary_block_mobile">';

			woocommerce_template_single_title(); // Product Title
			custom_woocommerce_star_rating(); // Rating
			woocommerce_template_single_price(); // Price
			woocommerce_template_single_excerpt(); // Excerpt or Description

			echo '<div class="custom_product_labels">';
				echo '<div class="custom_product_label"><img src="' . esc_url( get_stylesheet_directory_uri() . '/img/icons/delivery.svg' ) . '" alt="Free Delivery" /> Fast & Free Shipping</div>';
				echo '<div class="custom_product_label"><img src="' . esc_url( get_stylesheet_directory_uri() . '/img/icons/hot.svg' ) . '" alt="Selling fast" /> Selling Fast, Last Few Remaining</div>';
				echo '<div class="custom_product_label"><img src="' . esc_url( get_stylesheet_directory_uri() . '/img/icons/safe.svg' ) . '" alt="Safe payments" /> Safe & Secure Payment</div>';
			echo '</div>';

			woocommerce_template_single_add_to_cart(); // Add to Cart button
			woocommerce_template_single_sharing(); // Sharing buttons

		echo '</div>';
	echo '</div>';
}

/**
 * Removes specific actions from the WooCommerce single product summary.
 *
 * This function removes various actions from the WooCommerce single product summary, such as the product title,
 * rating, price, excerpt, add to cart button, meta information, and sharing buttons.
 *
 * @since 1.0.0
 */
function custom_remove_product_summary() {
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
}
add_action('init', 'custom_remove_product_summary');

/**
 * Adds a custom summary after the main content in WooCommerce.
 *
 * This function hooks into the 'woocommerce_after_main_content' action and calls the 'custom_output_product_summary' function with a priority of 20.
 *
 * @since 1.0.0
 */
function custom_add_summary_after_main_content() {
	add_action('woocommerce_after_main_content', 'custom_output_product_summary', 20);
}
add_action('init', 'custom_add_summary_after_main_content');

/**
 * Adds a custom summary after the product gallery in WooCommerce for mobile devices.
 */
function custom_add_summary_after_product_gallery() {
	add_action('woocommerce_after_single_product_summary', 'custom_output_product_summary_mobile', 5);
}
add_action('init', 'custom_add_summary_after_product_gallery');

/**
 * Adds a custom buy now bar after the single product in WooCommerce.
 *
 * This function adds a custom buy now bar below the single product in WooCommerce. It displays the price and title of the product, and includes a "Buy Now" button that triggers a scroll to the product summary section.
 *
 * @global WP_Product $product The current product object.
 *
 * @return void
 */
function add_custom_buy_now_bar() {
    global $product;

	$regular_price = floatval( $product->get_regular_price() );
	$sale_price = floatval( $product->get_sale_price() );
	$savings = $regular_price - $sale_price;
	$savings_text = '';

	if ( $product->is_on_sale() && $savings > 0 ) {
		$savings_text = '<span class="st-small-btn red-btn-bg savings-text">Save £' . number_format( $savings, 2 ) . '</span>';
	}
    ?>
    <div id="custom-buy-now-bar" class="custom-buy-now-bar" style="display:none;">
        <div class="buy-now-content">
            <span class="price"><?php echo $product->get_price_html(); ?></span>
			<?php echo $savings_text; ?>
            <button onclick="scrollToSummary()">Buy Now</button>
        </div>
    </div>
    <?php
}
add_action('woocommerce_after_single_product', 'add_custom_buy_now_bar');

add_filter('wc_product_sku_enabled', '__return_false');

/**
 * Adds a custom product label to WooCommerce products published within the last 6 months.
 *
 * This function checks the publish date of the product and compares it with the current date.
 * If the product was published within the last 6 months, it adds a "New Product" label to the product.
 *
 * @global WP_Post $product The current product object.
 *
 * @return void
 */
function add_custom_product_labels() {
    global $product;

    // Get the product's publish date
    $post_date = get_the_date('Y-m-d', $product->get_id());
    $post_date_timestamp = strtotime($post_date);
    $current_timestamp = time();

    // Calculate the difference in seconds
    $time_difference = $current_timestamp - $post_date_timestamp;

    // Six months in seconds (approximately 6 * 30 * 24 * 60 * 60)
    $six_months_in_seconds = 6 * 30 * 24 * 60 * 60;

    // Check if the product was published within the last 6 months
    if ($time_difference <= $six_months_in_seconds) {
        echo '<span class="new-product-label">New</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'add_custom_product_labels');