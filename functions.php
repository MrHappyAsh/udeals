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
 * Customize the title of WooCommerce products on the shop page or product archives.
 *
 * @param string $title The original title of the product.
 * @param int $id The ID of the product.
 * @return string The modified title of the product.
 */
add_filter( 'the_title', 'customize_woocommerce_product_title', 10, 2 );
function customize_woocommerce_product_title( $title, $id ) {
    // Only apply to WooCommerce products on the shop page or product archives
    if ( is_shop() || is_product_category() || is_product_tag() && get_post_type( $id ) === 'product' ) {
        if ( strlen( $title ) > 34 ) {
            $title = substr( $title, 0, 34 ) . '...';
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

	// if ( $review_count > 0 ) {
		// Output the rating HTML
		echo '<div class="star-rating">';
		for ($i = 1; $i <= 5; $i++) {
			if ($average >= $i) {
				echo '<span class="star filled">&#9733;</span>'; // Gold star
			} else {
				echo '<span class="star">&#9734;</span>'; // Grey star
			}
		}
		echo '<span class="rating-count"> (' . $review_count . ')</span>';
		echo '</div>';
	// }
}

// Remove default WooCommerce rating from shop loop
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
// Add custom rating to shop loop
add_action('woocommerce_after_shop_loop_item_title', 'custom_woocommerce_star_rating', 5);

// Remove default WooCommerce rating from product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
// Add custom rating to product page
add_action('woocommerce_single_product_summary', 'custom_woocommerce_star_rating', 10);

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
	if ( is_shop() ) {
		return false;
	}
	return $title;
}

/**
 * Adds custom images above the WooCommerce shop loop.
 */
function custom_images_before_shop_loop() {
	// Your image HTML here. For example:
	echo '<div class="shop-images-above-loop">';
		echo '<img src="' . get_template_directory_uri() . '/img/shop/pizza-oven.jpg" alt="Pizza Oven">';
		echo '<img src="' . get_template_directory_uri() . '/img/shop/health-fitness.jpg" alt="Health and Fitness">';
		echo '<img src="' . get_template_directory_uri() . '/img/shop/travel.jpg" alt="Travel">';
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'custom_images_before_shop_loop' );
