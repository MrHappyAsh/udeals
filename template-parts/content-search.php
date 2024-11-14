<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UDeals
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php udeals_post_thumbnail(); ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		
		<?php 
			// if post type is product, display the price
			if ( 'product' === get_post_type() ) {
				$product = wc_get_product( get_the_ID() );

				// Check if the product is variable or simple
				if ( $product->is_type( 'variable' ) ) {
					// Get variation prices
					$min_price = $product->get_variation_price( 'min', true );
					$max_price = $product->get_variation_price( 'max', true );
					$min_sale_price = $product->get_variation_sale_price( 'min', true );
					$max_sale_price = $product->get_variation_sale_price( 'max', true );

					// Display price range if applicable
					if ( $min_price !== $max_price ) {
						echo '<span class="price">' . wc_format_price_range( $min_price, $max_price ) . '</span>';
					} else {
						// Display the regular or sale price for single variation
						echo '<span class="price">' . ( $min_sale_price ? wc_price( $min_sale_price ) : wc_price( $min_price ) ) . '</span>';
					}

				} else {
					// For simple products
					$regular_price = $product->get_regular_price();
					$sale_price = $product->get_sale_price();

					if ( $sale_price ) {
						// If product is on sale, show sale and regular price
						echo '<span class="price"><del>' . wc_price( $regular_price ) . '</del> <ins>' . wc_price( $sale_price ) . '</ins></span>';
					} else {
						// Otherwise, show regular price
						echo '<span class="price">' . wc_price( $regular_price ) . '</span>';
					}
				}
			}
		?>
	</header><!-- .entry-header -->

</article><!-- #post-<?php the_ID(); ?> -->
