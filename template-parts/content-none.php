<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UDeals
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'udeals' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) :

			printf(
				'<p>' . wp_kses(
					/* translators: 1: link to WP admin new post page. */
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'udeals' ),
					array(
						'a' => array(
							'href' => array(),
						),
					)
				) . '</p>',
				esc_url( admin_url( 'post-new.php' ) )
			);

		elseif ( is_search() ) :
			?>

			<p class="text-center"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'udeals' ); ?></p>
			<?php
			get_search_form();

		else :
			?>

			<p class="text-center"><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'udeals' ); ?></p>
			<?php
			get_search_form();

		endif;
		?>

		<?php
		// Display the 8 latest WooCommerce products when no results are found
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => 4,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		$latest_products_query = new WP_Query( $args );

		if ( $latest_products_query->have_posts() ) :
			?>
			<h3 class="text-center"><?php esc_html_e( 'Latest Products', 'udeals' ); ?></h3>
			<ul class="products">
				<?php
				while ( $latest_products_query->have_posts() ) :
					$latest_products_query->the_post();
					?>

					<li class="product">
						<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
							<?php woocommerce_template_loop_product_thumbnail(); ?>
							<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
							<span class="price"><?php woocommerce_template_loop_price(); ?></span>
						</a>
					</li>

				<?php
				endwhile;
				?>
			</ul><!-- .products -->

			<?php
			wp_reset_postdata();
		endif;
		?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
