<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>

<!-- Output woocommerce messages -->
<?php wc_print_notices(); ?>

<div class="product-section-60-40" id="top-block">
    <div>
        <?php
            // Get the product featured image
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
        ?>
        
        <!-- Main Image Section -->
        <img class="large_featured_image" id="main-featured-image" src="<?php echo $featured_image[0]; ?>" alt="<?php echo $product->get_name(); ?>" />

        <!-- Product Gallery -->
        <div class="product_gallery">
            <?php
                // Add the featured image as the first thumbnail with the "active" class
                echo '<div class="thumb">';
                echo '<img src="' . esc_url($featured_image[0]) . '" alt="' . esc_attr($product->get_name()) . '" class="active" onclick="updateMainImage(this)" />';
                echo '</div>';

                // Get the product gallery images
                $attachment_ids = $product->get_gallery_image_ids();
                foreach( $attachment_ids as $attachment_id ) {
                    $image_link = wp_get_attachment_url( $attachment_id );
                    echo '<div class="thumb">';
                    echo '<img src="' . esc_url($image_link) . '" alt="' . esc_attr($product->get_name()) . '" onclick="updateMainImage(this)" />';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
    <div>
        <?php woocommerce_template_single_title(); ?>

        <a class="link-no-style" href="#review-block"><?php custom_woocommerce_star_rating(); ?></a>

        <?php woocommerce_template_single_price(); ?>

        <div id="add-to-cart">
            <?php woocommerce_template_single_add_to_cart(); ?>
        </div>

        <div class="promo-box">
            <span class="promo-box-heading text-center">Free Eye Mask Included</span>
            <p>Get UPods for just £19.99 for a limited time only and we'll give you a free luxury eye mask <em>(worth £14.99)</em> so you get the perfect night sleep.</p>
        </div>

        <?php woocommerce_template_single_excerpt(); ?>

    </div>
</div>

<div class="product-section-30-30-30 product_icons_block">
    <div class="icon_card box-shadow">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/shield.svg" alt="UPods warranty is valid for 365 days.">
        <h2 class="icon_card_title">365 Day<br>Warranty</h2>
    </div>
    <div class="icon_card box-shadow">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/reviews.svg" alt="UPods has over 1000 five star reviews.">
        <h2 class="icon_card_title">1000+<br>5 Star Reviews</h2>
    </div>
    <div class="icon_card box-shadow">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/return.svg" alt="UPods are delivered anywhere in the world at no extra cost to you.">
        <h2 class="icon_card_title">Fast & Free<br>UK Delivery</h2>
    </div>
</div>

<div class="product-section-50-50 product-section-dark product_showcase">
    <div>
        <h3>Meet UPods,<br>Silence is golden</h3>
        <p>Meet UPods, our debut earplugs crafted for those who seek true quiet. Designed to blend comfort with powerful noise reduction, UPods fit every ear securely, creating a peaceful escape whether you're at home, traveling, or winding down. Discover the future of earplugs with UPods - where silence meets comfort.</p>
    </div>
    <div>
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/upods/upods-showcase.webp" alt="UPods are the perfect way to find peace and quiet. UPods ear plugs.">
    </div>
</div>

<div class="product-section-30-30-30">
    <div class="image_heading_block">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/upods/upods-woman-travelling.webp" alt="A lady traveling on a train using UPods to work peacefully.">
        <h4 class="image_heading_block_heading">Travel in peace</h4>
    </div>
    <div class="image_heading_block">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/upods/upods-peaceful.webp" alt="UPods can be used to find inner peace.">
        <h4 class="image_heading_block_heading">Silence is golden</h4>
    </div>
    <div class="image_heading_block">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/upods/upods-woman-sleeping-2.webp" alt="A person getting a good night sleep with the aid of UPods ear plugs.">
        <h4 class="image_heading_block_heading">Wake up refreshed</h4>
    </div>
</div>

<div id="review-block" class="product-section-100 review-block">

    <h5 class="medium_heading text-center">What people are saying</h5>
    <?php product_reviews_banner(); ?>
</div>

<div class="product-section-100 faq-block">
    <h6 class="medium_heading text-center">Frequently Asked Questions</h6>

    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                Why buy UPods?
                <span class="faq-icon">◀</span>
            </div>
            <div class="faq-answer">UPods offer effective noise reduction and comfort, perfect for enhancing focus, sleep, and peaceful travel.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                How much noise reduction can I expect from UPods?
                <span class="faq-icon">◀</span>
            </div>
            <div class="faq-answer">UPods deliver up to 24 dB of noise reduction, effectively filtering out unwanted sounds. Perfect for sleep, intense focus, travel, and commuting.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                Will UPods fit my ears?
                <span class="faq-icon">◀</span>
            </div>
            <div class="faq-answer">UPods ear tips have been redesigned to fit a wider range of ear shapes, providing a secure and comfortable fit for all sizes. Each set includes three different tip sizes to ensure the perfect fit for ears big and small.</div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                Are UPods Durable?
                <span class="faq-icon">◀</span>
            </div>
            <div class="faq-answer">UPods earplugs are crafted from durable silicone, offering high-quality noise reduction consistently, day after day and night after night.</div>
        </div>
    </div>

    <a class="large-btn green-btn-bg text-center" href="#top-block">BUY YOURS TODAY – <s>£49.99</s> £19.99</a>

</div>