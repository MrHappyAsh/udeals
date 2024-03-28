<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UDeals
 */

?>
	</div>

	<footer id="colophon" class="site-footer">

		<div class="footer-menus">
			<div class="footer-menu">
				<h6 class="menu-header">Shop</h6>
				<?php wp_nav_menu( array( 'menu' => 'footer-1', 'theme_location' => 'footer-1', 'menu_class' => 'footer-menu' ) ); ?>
			</div>
			<div class="footer-menu">
				<h6 class="menu-header">Seasonal</h6>
				<?php wp_nav_menu( array( 'menu' => 'footer-2', 'theme_location' => 'footer-2', 'menu_class' => 'footer-menu' ) ); ?>
			</div>
			<div class="footer-menu">
				<h6 class="menu-header">Support</h6>
				<?php wp_nav_menu( array( 'menu' => 'footer-3', 'theme_location' => 'footer-3', 'menu_class' => 'footer-menu' ) ); ?>
			</div>
			<div class="footer-menu">
				<h6 class="menu-header">Let's Get Social</h6>
				<ul class="footer-menu">
					<li class="menu-item"><a href="https://www.facebook.com/">Facebook</a></li>
					<li class="menu-item"><a href="https://www.pinterest.com/">Pinterest</a></li>
					<li class="menu-item"><a href="https://www.instagram.com/">Instagram</a></li>
					<li class="menu-item"><a href="https://www.tiktok.com/">TikTok</a></li>
				</ul>
			</div>
		</div>

		<div class="site-info">
			<span class="footer_notice">&copy; 2024 UDeals Ltd | All rights reserved.</span>
			<span class="footer_notice">Company Number: 15447232 - Registered England & Wales | Registered Office: 15b Sawley Park, Derby, DE21 6AS</span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
