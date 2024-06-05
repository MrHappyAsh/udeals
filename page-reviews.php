<?php
/*
	Template Name: Reviews
*/
$confirmation = false;
$order_id = isset($_GET['order_id']) ? absint($_GET['order_id']) : 0;
$order = $order_id ? wc_get_order($order_id) : null;

if ($order) {
    $already_reviewed = $order->get_meta('_order_reviewed_date');
    $order_key = $order->get_order_key();
} else {
    $already_reviewed = false;
    $order_key = '';
}

$url_order_key = isset($_GET['order_key']) ? sanitize_text_field($_GET['order_key']) : '';

if (isset($_POST['review_submit']) && empty($already_reviewed) && $url_order_key === $order_key) {
    // get form data
    $order_id = absint($_POST['order_id']);
    $products = $_POST['products'];
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $email = sanitize_email($_POST['email']);

    // array to hold all ratings
    $all_ratings = [];

    // loop through products
    foreach ($products as $product) {
        $product_id = absint($product['product_id']);
        $rating = intval($product['rating']);
        $review = sanitize_textarea_field($product['review']);

        if ($rating > 0) {
            $all_ratings[] = $rating;
        }

        if ($rating > 0) {
            $commentdata = array(
                'comment_approved' => 0,
                'comment_agent' => sanitize_text_field($_SERVER['HTTP_USER_AGENT']),
                'comment_author_IP' => sanitize_text_field($_SERVER['REMOTE_ADDR']),
                'comment_author' => $first_name . ' ' . $last_name,
                'comment_author_email' => $email,
                'comment_content' => $review,
                'comment_post_ID' => $product_id,
                'comment_type' => 'review',
                'comment_meta' => array(
                    'rating' => $rating,
                    'verified' => 1,
                )
            );

            // insert review into database
            $comment_id = wp_insert_comment($commentdata);

            if ($comment_id) {
                $confirmation = true;
                // get the current date and time
                $order->update_meta_data('_order_reviewed_date', current_time('mysql'));
                $order->save();
            }
        }
    }

    // get lowest rating from all ratings
    $lowest_rating = min($all_ratings);

} else {
    if ($order_id) {
        $order = wc_get_order($order_id);

        if ($order) {
            // get products in order
            $items = $order->get_items();
            // get billing first name from order
            $customer_first_name = $order->get_billing_first_name();
            // get billing last name from order
            $customer_last_name = $order->get_billing_last_name();
            // get billing email from order
            $customer_email = $order->get_billing_email();
        } else {
            $order_id = 0;
        }
    }
}

get_header(); ?>

    <main id="main" class="site-main content-width">

        <div class="container-fluid default-hero" id="reviews-hero">
            <?php if ($confirmation) { ?>
                <h1 class="text-center">Thank you!</h1>
            <?php } else { ?>
                <h1 class="text-center">Leave your review</h1>
                <p class="text-center">Help us out by leaving a review for the items that you purchased.</p>
            <?php } ?>
        </div><!--container-->

        <div class="container reviews_page_container" id="default-narrow-page-template">
            <?php
            if ($order_id === 0 || $order_key !== $url_order_key) {
                echo '<h2 style="text-align: center;">Whoops, something went wrong.</h2>';
                echo '<p style="text-align: center;">Sorry, we could not find your order.</p>';
                echo '<a href="' . site_url() . '/my-account" class="ue_branded_btn">My Account</a>';
            } else if (!empty($already_reviewed)) {
                echo '<h2 style="text-align: center;">Already left your review.</h2>';
                echo '<p style="text-align: center;">Looks like you have already left a review for this order.</p>';
                echo '<a href="' . site_url() . '/my-account" class="ue_branded_btn">My Account</a>';
            } else if ($confirmation){
                if ($lowest_rating >= 4) {
                    echo '<p style="text-align: center;">Thank you so much for your review. Please also share on Google it only takes a minute.</p>';
                    echo '<a href="https://g.page/r/CS2ZifziN4DXEBM/review" target="_blank"><img style="display:block;max-width:300px;height:auto;margin:25px auto;" src="' . get_stylesheet_directory_uri() . '/img/google-reviews.png" alt="Review us on Google" /></a>';
                    echo '<p style="text-align: center;">As a thank you, get 10% off your next order by using the coupon code below at the checkout:</p>';
                    echo '<span style="display:block;text-align:center;font-size:1.5rem;font-weight:bold;color:#272727;background-color:#dbdbdb;padding:5px 15px;margin: 10px auto;max-width:280px;border: 2px dashed #a9a9a9;">REVIEW10</span>';
                } else {
                    echo '<p style="text-align: center;">Your review means a lot to us and will help our business continue to improve and reach potential new participants.</p>';
                    echo '<a href="' . site_url() . '/my-account" class="ue_branded_btn">My Account</a>';
                }
            } else {
                echo '<p>Hi ' . esc_html($customer_first_name) . ', thank you for your recent purchase. You can leave your reviews for your ' . count($items) . ' items below.</p>'; ?>

                <form id="reviews_form" action="" method="post">                            
                    <?php foreach ($items as $x => $item) {
                        $product_id = $item->get_product_id();
                        $product = wc_get_product($product_id);
                        $product_name = $product->get_name();
                        $product_image_url = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), [150, 150])[0];
                        $product_image_alt = get_post_meta(get_post_thumbnail_id($product_id), '_wp_attachment_image_alt', true);
                    ?>
                        <div class="reviews_form_item">
                            <div class="form_row">
                                <span class="reviews_form_product_name"><?php echo esc_html($product_name); ?></span>
                                <img class="reviews_form_product_image" src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_image_alt); ?>" />
                            </div>
                            <input type="hidden" name="order_id" value="<?php echo esc_attr($order_id); ?>">
                            <input type="hidden" name="products[<?php echo $x; ?>][product_id]" value="<?php echo esc_attr($product_id); ?>">
                            <div class="form_row" style="align-items:start">
                                <div class="ratings_holder">
                                    <label for="products[<?php echo $x; ?>][rating]">Rating
                                        <div class="ratings_stars">
                                            <?php for ($i = 5; $i >= 1; $i--) { ?>
                                                <span class="reviews_form_star" data-rating="<?php echo esc_attr($i); ?>"></span>
                                            <?php } ?>
                                        </div>
                                    </label>
                                    <select style="display:none;" name="products[<?php echo $x; ?>][rating]" id="rating_<?php echo esc_attr($product_id); ?>">
                                        <option value="" selected disabled></option>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                                <label id="review_textarea" for="products[<?php echo $x; ?>][review]">Your Review
                                    <textarea name="products[<?php echo $x; ?>][review]" placeholder="Leave us your feedback here..."></textarea>
                                </label>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="form_row">
                        <label for="first_name">First Name
                            <input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($customer_first_name); ?>">
                        </label>
                        <label for="last_name">Last Name
                            <input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($customer_last_name); ?>">
                        </label>
                        <label for="email">Email
                            <input type="email" name="email" id="email" value="<?php echo esc_attr($customer_email); ?>">
                        </label>
                    </div>
                    <p class="form_small_text">By submitting this form, you agree to our <a href="<?php echo site_url(); ?>/terms-and-conditions">terms and conditions</a> and <a href="<?php echo site_url(); ?>/privacy-policy">privacy policy</a>. Your name will be displayed along with your review. Your email will never be displayed publicly.</p>
                    <input type="submit" name="review_submit" value="Submit">
                </form>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Get all star elements
                    const ratingStars = document.querySelectorAll('.reviews_form_star');

                    ratingStars.forEach(star => {
                        star.addEventListener('click', function() {
                            // Get the rating value from the clicked star
                            const ratingValue = this.dataset.rating;
                            // Get the parent element containing the select field
                            const parent = this.closest('.form_row');
                            const ratingSelect = parent.querySelector('select');

                            // Set the value of the select field
                            ratingSelect.value = ratingValue;

                            // Remove the 'active' class from all stars
                            const currentProductStars = parent.querySelectorAll('.reviews_form_star');
                            currentProductStars.forEach(star => star.classList.remove('active'));

                            // Add the 'active' class to the selected stars
                            currentProductStars.forEach(star => {
                                if (star.dataset.rating <= ratingValue) {
                                    star.classList.add('active');
                                }
                            });
                        });
                    });
                });
                </script>

    <?php   } ?>

        </div>

    </main><!-- #main -->

<?php
get_footer();
?>
