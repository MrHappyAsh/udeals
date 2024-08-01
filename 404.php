<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package UDeals
 */

get_header();
?>

	<main id="primary" class="site-main content-width">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title text-center"><?php esc_html_e( 'Whoops! That page can&rsquo;t be found.', 'udeals' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content text-center">
				<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'udeals' ); ?></p>

					<?php
					get_search_form();
					?>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
