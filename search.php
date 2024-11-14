<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package UDeals
 */

get_header();
?>

	<main id="primary" class="site-main content-width">

		<?php
		// Custom WP Query to fetch posts and products
		$search_query = new WP_Query( array(
			'post_type' => array( 'product' ),
			's' => get_search_query(),
			'posts_per_page' => 12, // You can adjust the number of posts to display
		) );

		if ( $search_query->have_posts() ) :
		?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'udeals' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<div class="search_grid">

				<?php
				// Start the custom Loop
				while ( $search_query->have_posts() ) :
					$search_query->the_post();

					// Use your template part to display the search results
					get_template_part( 'template-parts/content', 'search' );

				endwhile;
				?>

			</div><!-- .search_grid -->

			<?php
			// Pagination for custom query, moved outside of .search_grid
			the_posts_pagination( array(
				'prev_text' => __( 'Previous', 'udeals' ),
				'next_text' => __( 'Next', 'udeals' ),
				'mid_size'  => 2,
				'before_page_number' => '<span class="meta-nav nav-links">',
				'after_page_number' => '</span>',
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		<?php
		// Reset post data after custom query
		wp_reset_postdata();
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
