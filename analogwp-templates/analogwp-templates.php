<?php
/**
 * Plugin main file.
 *
 * @package     Analog
 * @copyright   2019-2024 SmallTownDev.
 * @link        https://analogwp.com
 *
 * @wordpress-plugin
 * Plugin Name: Style Kits for Elementor
 * Plugin URI:  https://analogwp.com/
 * Description: Style Kits extends the Elementor theme styles editor with more global styling options. Boost your design workflow in Elementor with intuitive global controls and theme style presets.
 * Version:     2.3.4
 * Author:      AnalogWP
 * Author URI:  https://analogwp.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ang
 * Requires at least: 6.0
 * Requires PHP: 7.4
 *
 * Elementor tested up to: 3.28.1
 * Elementor Pro tested up to: 3.28.1
 */

defined( 'ABSPATH' ) || exit;

define( 'ANG_ELEMENTOR_MINIMUM', '3.20.0' );
define( 'ANG_PHP_MINIMUM', '7.4' );
define( 'ANG_WP_MINIMUM', '6.0' );
define( 'ANG_VERSION', '2.3.4' );
define( 'ANG_PLUGIN_FILE', __FILE__ );
define( 'ANG_PLUGIN_URL', plugin_dir_url( ANG_PLUGIN_FILE ) );
define( 'ANG_PLUGIN_DIR', plugin_dir_path( ANG_PLUGIN_FILE ) );
define( 'ANG_PLUGIN_BASE', plugin_basename( ANG_PLUGIN_FILE ) );

/**
 * Handles plugin activation.
 *
 * Throws an error if the plugin is activated on an older version than PHP 5.6.
 *
 * @since 1.6.0
 * @access private
 * @return void
 */
function analog_activate_plugin() {
	if ( version_compare( PHP_VERSION, ANG_PHP_MINIMUM, '<' ) ) {
		wp_die(
			/* translators: %s: version number */
			esc_html( sprintf( __( 'Style Kit for Elementor requires PHP version %s', 'ang' ), ANG_PHP_MINIMUM ) ),
			esc_html__( 'Error Activating', 'ang' )
		);
	}

	do_action( 'analog_activation' );
}

register_activation_hook( __FILE__, 'analog_activate_plugin' );

/**
 * Handles plugin deactivation.
 *
 * @since 1.6.0
 * @access private
 * @return void
 */
function analog_deactivate_plugin() {
	if ( version_compare( PHP_VERSION, ANG_PHP_MINIMUM, '<' ) ) {
		return;
	}

	do_action( 'analog_deactivation' );
}

register_deactivation_hook( __FILE__, 'analog_deactivate_plugin' );

/**
 * Fail loading, if WordPress version requirements not met.
 *
 * @since 1.1
 * @return void
 */
function analog_fail_wp_version() {
	/* translators: %s: WordPress version */
	$message      = sprintf( esc_html__( 'Style Kits requires WordPress version %s+. Because you are using an earlier version, the plugin is currently NOT RUNNING.', 'ang' ), ANG_WP_MINIMUM );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );

	echo wp_kses_post( $html_message );
}

/**
 * Elementor version requirements are not met.
 *
 * @return mixed
 */
function analog_require_minimum_elementor() {
	$file_path = 'elementor/elementor.php';

	$link = add_query_arg(
		array(
			'action' => 'upgrade-plugin',
			'plugin' => $file_path,
		),
		admin_url( 'update.php' )
	);

	$update_url = wp_nonce_url( $link, 'upgrade-plugin_' . $file_path );

	/* translators: %s: Minimum required Elementor version. */
	$message = '<p>' . sprintf( __( 'Style Kits requires Elementor v%s or newer in order to work. Please update Elementor to the latest version.', 'ang' ), ANG_ELEMENTOR_MINIMUM ) . '</p>';

	$versions = get_transient( 'ang_rollback_versions_' . ANG_VERSION );

	$message .= '<p>';
	/* translators: %s: Link to update Elementor. */
	$message .= sprintf( '<a href="%s" class="button-primary">%s</a>', $update_url, __( 'Update Elementor Now', 'ang' ) );
	/* translators: %s: Link to rollback plugin to previous version. */
	$message .= sprintf(
		'<a href="%s" class="button-secondary" style="margin-left:10px">%s</a>',
		wp_nonce_url( admin_url( 'admin-post.php?action=ang_rollback&version=' . $versions[0] ), 'ang_rollback' ),
		/* translators: %s: Version number. */
		sprintf( __( 'Rollback to v%s', 'ang' ), $versions[0] )
	);
	$message .= '</p>';

	echo '<div class="error"><p>' . $message . '</p></div>'; // @codingStandardsIgnoreLine
}

/**
 * Fail plugin initiialization if requirements are not met.
 *
 * @return mixed|bool
 */
function analog_fail_load() {
	if ( ! function_exists( 'get_current_screen' ) ) {
		require_once ABSPATH . 'wp-admin/includes/screen.php';
	}

	$screen = get_current_screen();

	if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
		return;
	}

	$file_path = 'elementor/elementor.php';

	$is_not_activated = false;
	$is_not_installed = false;

	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$installed_plugins = get_plugins();
	$elementor         = isset( $installed_plugins[ $file_path ] );

	if ( $elementor ) {
		$is_not_activated = true;
	} else {
		$is_not_installed = true;
	}

	if ( $is_not_activated ) {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$activation_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $file_path . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $file_path );
		$message        = '<p>' . __( 'Style Kits is not working because you need to activate the Elementor plugin.', 'ang' ) . '</p>';
		$message       .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $activation_url, __( 'Activate Elementor Now', 'ang' ) ) . '</p>';
	} elseif ( $is_not_installed ) {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=elementor' ), 'install-plugin_elementor' );
		$message     = '<p>' . __( 'Style Kits is not working because you need to install the Elementor plugin.', 'ang' ) . '</p>';
		$message    .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', $install_url, __( 'Install Elementor Now', 'ang' ) ) . '</p>';
	}

	echo '<div class="error"><p>' . $message . '</p></div>'; // @codingStandardsIgnoreLine
}

// Third party dependencies.
$vendor_file = __DIR__ . '/third-party/vendor/scoper-autoload.php';

if ( is_readable( $vendor_file ) ) {
	require_once $vendor_file;
}

if ( ! function_exists( 'sk_fs' ) ) {
	/**
	 * Create a helper function for easy SDK access.
	 */
	function sk_fs() {
		global $sk_fs;

		if ( ! isset( $sk_fs ) ) {
			// Include Freemius SDK.
			require_once dirname( __FILE__ ) . '/freemius/start.php';

			$sk_fs = fs_dynamic_init(
				array(
					'id'             => '17032',
					'slug'           => 'analogwp-templates',
					'type'           => 'plugin',
					'public_key'     => 'pk_e05579cda0ad78db31e94616185cc',
					'is_premium'     => false,
					'has_addons'     => true,
					'has_paid_plans' => false,
					'menu'           => array(
						'slug'       => 'analogwp_templates',
						'first-path' => 'admin.php?page=analog_onboarding&from=freemius',
						'support'    => false,
					),
				)
			);
		}

		return $sk_fs;
	}

	// Init Freemius.
	sk_fs();
	// Signal that SDK was initiated.
	do_action( 'sk_fs_loaded' );
}

/**
 * Fire up plugin instance.
 *
 * @since 1.6.0 Add PHP version check.
 */
add_action(
	'plugins_loaded',
	static function () {
		if ( version_compare( PHP_VERSION, ANG_PHP_MINIMUM, '<' ) ) {
			wp_die(
			/* translators: %s: version number */
				esc_html( sprintf( __( 'Style Kit for Elementor requires PHP version %s', 'ang' ), ANG_PHP_MINIMUM ) ),
				esc_html__( 'Error Activating', 'ang' )
			);
		}

		// Begin onboarding.
		require_once ANG_PLUGIN_DIR . 'inc/class-onboarding.php';

		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', 'analog_fail_load' );
			return;
		}

		if ( ! version_compare( ELEMENTOR_VERSION, ANG_ELEMENTOR_MINIMUM, '>=' ) ) {
			// Include files temporarily, required for rollbacks to work.
			require_once ANG_PLUGIN_DIR . 'inc/class-base.php';
			require_once ANG_PLUGIN_DIR . 'inc/Core/Storage/Transients.php';
			require_once ANG_PLUGIN_DIR . 'inc/elementor/class-tools.php';
			require_once ANG_PLUGIN_DIR . 'inc/Utils.php';

			add_action( 'admin_notices', 'analog_require_minimum_elementor' );
			return;
		}

		if ( ! version_compare( get_bloginfo( 'version' ), ANG_WP_MINIMUM, '>=' ) ) {
			add_action( 'admin_notices', 'analog_fail_wp_version' );
			return;
		}

		require_once ANG_PLUGIN_DIR . 'inc/Plugin.php';

		\Analog\Plugin::load( ANG_PLUGIN_FILE );
	}
);
