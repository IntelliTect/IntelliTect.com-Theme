<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php get_template_part( 'template-parts/footer/footer', 'widgets' ); ?>
		<div class="site-info">
			<?php $blog_info = get_bloginfo( 'name' ); ?>

			<?php
			if ( function_exists( 'the_privacy_policy_link' ) ) {
				the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
			}
			?>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'twentynineteen' ); ?>">
					<?php
					$menu = wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'depth'          => 2,
							'echo'           => false,
						)
					);
					$close_ul_pos = strripos($menu, "</ul>");

					$template_dir = get_template_directory_uri();
					$last_column = "
					<li class='menu-item menu-item-has-children'>
						<a >&nbsp;</a>

						<img src='$template_dir/static/Microsoft-Gold-Partner-Logo.jpg' />

						<a >&nbsp;</a>

						<div class='social-links' >
							<a href='https://www.facebook.com/IntelliTect/' target='_blank'>
								<i class='fab fa-facebook-f'></i>
							</a>
							<a href='https://twitter.com/intellitect' target='_blank'>
								<i class='fab fa-twitter'></i>
							</a>
							<a href='https://www.linkedin.com/company/intellitect/' target='_blank'>
								<i class='fab fa-linkedin-in'></i>
							</a>
							<a href='mailto:Info@IntelliTect.com'>
								<i class='fa fa-envelope'></i>
							</a>
						</div>
					</li>
					";

					$menu = substr_replace($menu, $last_column, $close_ul_pos, 0);
					echo $menu;
					?>
					<p style='text-align: center;'>
						© IntelliTect <?= date("Y") ?>
						&nbsp;&nbsp;
						<a href='/site-map/'>Site Map</a>
						&nbsp;&nbsp;
						<a href='/privacy-policy/'>Our Privacy Policy</a>
					</p>
				</nav><!-- .footer-navigation -->
			<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
