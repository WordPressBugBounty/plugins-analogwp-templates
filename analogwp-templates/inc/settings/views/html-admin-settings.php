<?php
/**
 * Admin View: Settings
 *
 * @package Analog
 * @since 1.3.8
 */

namespace Analog\Settings\views;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tab_exists        = isset( $tabs[ $current_tab ] ) || has_action( 'ang_sections_' . $current_tab ) || has_action( 'ang_settings_' . $current_tab ) || has_action( 'ang_settings_tabs_' . $current_tab );
$current_tab_label = $tabs[ $current_tab ] ?? '';

global $current_user;

if ( ! $tab_exists ) {
	wp_safe_redirect( admin_url( 'admin.php?page=ang-settings' ) );
	exit;
}
?>
<div class="wrap ang <?php echo esc_attr( $current_tab ); ?>">
	<h1 class="menu-title"><?php esc_html_e( 'Style Kits Settings', 'ang' ); ?></h1>
	<div class="ang-wrapper">
		<form method="<?php echo esc_attr( apply_filters( 'ang_settings_form_method_tab_' . $current_tab, 'post' ) ); ?>" id="mainform" action="" enctype="multipart/form-data">
			<nav class="nav-tab-wrapper ang-nav-tab-wrapper">
				<?php

				foreach ( $tabs as $slug => $label ) {
					echo '<a href="' . esc_html( admin_url( 'admin.php?page=ang-settings&tab=' . esc_attr( $slug ) ) ) . '" class="nav-tab ' . ( $current_tab === $slug ? 'nav-tab-active' : '' ) . '">' . esc_html( $label ) . '</a>';
				}

				do_action( 'ang_settings_tabs' );

				?>
			</nav>
			<div class="tab-content">
				<h1 class="screen-reader-text"><?php echo esc_html( $current_tab_label ); ?></h1>
				<?php
					do_action( 'ang_sections_' . $current_tab );

					self::show_messages();

					do_action( 'ang_settings_' . $current_tab );
				?>
				<p class="submit">
					<?php if ( empty( $GLOBALS['hide_save_button'] ) ) : ?>
						<button name="save" class="button-primary ang-save-button" type="submit" value="<?php esc_attr_e( 'Save changes', 'ang' ); ?>"><?php esc_html_e( 'Save changes', 'ang' ); ?></button>
					<?php endif; ?>
					<?php wp_nonce_field( 'ang-settings' ); ?>
				</p>
			</div>
		</form>
		<div class="sidebar">
			<?php do_action( 'ang_sidebar_start' ); ?>

			<?php if ( ! class_exists( '\AnalogWP\CustomLibrary\Plugin' ) ) : ?>
				<div class="promo">
					<div>
						<svg width="48" height="48" viewBox="0 0 99 99" fill="none" xmlns="http://www.w3.org/2000/svg">
							<g clip-path="url(#clip0_4170_3917)">
								<path d="M49.5 99C76.8381 99 99 76.8381 99 49.5C99 22.1619 76.8381 0 49.5 0C22.1619 0 0 22.1619 0 49.5C0 76.8381 22.1619 99 49.5 99Z" fill="#232624"/>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M61.0206 35.3574H35.3572V61.0208H38.4217V38.4219H61.0206V35.3574Z" fill="white"/>
								<path d="M66.0007 40.3359H40.3373V65.9993H66.0007V40.3359Z" fill="white"/>
							</g>
							<defs>
								<clipPath id="clip0_4170_3917">
									<rect width="99" height="99" fill="white"/>
								</clipPath>
							</defs>
						</svg>
					</div>
					<h3><a href="https://analogwp.com/custom-library-for-elementor/?utm_medium=plugin&utm_source=settings&utm_campaign=style+kits" target="_blank"><?php esc_html_e( 'Meet Custom Library for Elementor', 'ang' ); ?></a></h3>

					<p>Now you can curate and access your own library of templates right inside the editor. Build faster, stay organized, and empower your clients with a seamless design workflow by providing them with essential patterns to build new layouts with consistency.</p>

					<p><a href="https://analogwp.com/custom-library-for-elementor/?utm_medium=plugin&utm_source=settings&utm_campaign=style+kits" target="_blank" class="button button-secondary">Learn more</a></p>
				</div>
			<?php endif; ?>

			<?php if ( ! class_exists( '\AnalogPro\Plugin' ) ) : ?>
			<div class="upgrade-box">
				<h3><?php esc_html_e( 'Upgrade to Style Kits Pro with a 15% discount', 'ang' ); ?></h3>

				<p>Add your email address and we will send you a 15% discount code for your Style Kits PRO purchase.</p>

				<form id="js-ang-request-discount" method="post">
					<input required type="email" class="regular-text" name="email" value="<?php echo esc_attr( $current_user->user_email ); ?>" placeholder="<?php esc_attr_e( 'Your Email', 'ang' ); ?>">
					<input required type="text" class="regular-text" name="first_name" value="<?php echo esc_attr( $current_user->first_name ); ?>" placeholder="<?php esc_attr_e( 'First Name', 'ang' ); ?>">
					<input type="submit" class="button" style="width:100%" value="<?php esc_attr_e( 'Send me the coupon', 'ang' ); ?>">
				</form>

				<p>
					<?php
					echo sprintf(
							/* translators: %s: Link to AnalogWP privacy policy. */
						esc_html__( 'By submitting your details, you agree to our %s.', 'ang' ),
						'<a target="_blank" href="https://analogwp.com/privacy-policy/">' . esc_html__( 'privacy policy', 'ang' ) . '</a>'
					);
					?>
				</p>
			</div>
			<?php endif; ?>

			<div class="promo">
				<div class="docs">
					<h3><?php esc_html_e( 'Documentation', 'ang' ); ?></h3>
					<p>
						<?php esc_html_e( 'Need help with Style Kits?', 'ang' ); ?>
						<a href="<?php echo esc_url( 'https://analogwp.com/docs/' ); ?>" target="_blank"><?php esc_html_e( 'Visit the online docs', 'ang' ); ?></a>
					</p>
				</div>
				<div class="social">
					<a href="https://facebook.com/analogwp" target="_blank"><span class="dashicons dashicons-facebook-alt"></span></a>
					<a href="https://twitter.com/analogwp" target="_blank"><span class="dashicons dashicons-twitter"></span></a>
					<a href="https://instagram.com/analogwp" target="_blank"><span class="dashicons dashicons-instagram"></span></span></a>
				</div>
			</div>

			<?php do_action( 'ang_sidebar_end' ); ?>
		</div>
	</div>
</div>
