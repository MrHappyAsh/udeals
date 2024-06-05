<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

global $product;

// Initialize variables for savings text
$savings_text = '';

if ( $product->is_type( 'variable' ) ) {
    // Placeholder for variable products
    $savings_text = '<span class="st-small-btn red-btn-bg savings-text" id="savings-text"></span>';
} else {
    // For simple products, get the regular price and sale price
    $regular_price = floatval( $product->get_regular_price() );
    $sale_price = floatval( $product->get_sale_price() );
    $savings = $regular_price - $sale_price;

    // Calculate savings
    if ( $product->is_on_sale() && $savings > 0 ) {
        $savings_text = '<span class="st-small-btn red-btn-bg savings-text">Save £' . number_format( $savings, 2 ) . '</span>';
    }
}
?>
<p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>">
    <?php
    if ($savings > 0) {
        echo $savings_text;
    }
    ?>
    <?php echo $product->get_price_html(); ?>    
</p>
