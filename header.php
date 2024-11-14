<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UDeals
 */

// Calculate the cart quantity
$cart_qty = WC()->cart->get_cart_contents_count();

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<script>!function(s,a,e,v,n,t,z){if(s.saq)return;n=s.saq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!s._saq)s._saq=n;n.push=n;n.loaded=!0;n.version='1.0';n.queue=[];t=a.createElement(e);t.async=!0;t.src=v;z=a.getElementsByTagName(e)[0];z.parentNode.insertBefore(t,z)}(window,document,'script','https://tags.srv.stackadapt.com/events.js');saq('ts', 'h3q_v_B6Vf-LMIsFg8akKg');</script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'udeals' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="content-width flex-row">
			<div class="site-branding">
				<?php
				// the_custom_logo();
				echo '<a href="' . site_url() . '"><img src="' . get_stylesheet_directory_uri() . '/img/logo/udeals-white-logo.svg" alt="UDeals" class="custom-logo" /></a>';
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$udeals_description = get_bloginfo( 'description', 'display' );
				if ( $udeals_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $udeals_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
				<?php endif; ?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
				<span class="bar1"></span>
				<span class="bar2"></span>
				<span class="bar3"></span>
			</button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'container_id'   => 'primary-menu-container',
					)
				);
				?>
			</nav><!-- #site-navigation -->

			<span class="pipe_seperator">&nbsp;</span>

			<div class="header_icon_row">
				<div class="header_icon_block">
					<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>/kit-list/">
						<img class="header_block_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/kit-list-white.svg" alt="Kit List"/>
					</a>
				</div>
				<div class="header_icon_block">
					<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">
						<img class="header_block_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/profile-white.svg" alt="My Account"/>
					</a>
				</div>
				<div class="header_icon_block">
					<a href="<?php echo wc_get_cart_url(); ?>">
						<img class="header_block_icon" src="<?php echo get_stylesheet_directory_uri(); ?>/img/icons/basket-white.svg" alt="Shopping cart" />
						<?php if ( $cart_qty > 0 ) {  ?>
							<span class="cart_count">
								<?php echo $cart_qty; ?>
							</span>
						<?php } ?>
					</a>
				</div>
			</div>
			
		</div>
		<div id="top_bar">
			<div class="content-width">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'top-bar-menu',
							'container_class' => 'top_bar_items', // Add the class 'top_bar_items'
						)
					);
				?>
			</div>
		</div>
	</header><!-- #masthead -->

	<div class="main-content">