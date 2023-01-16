<?php
/**
 * Warns the administrator when WP_DEBUG is enabled
 *
 * @package wp-tweaks
 */

add_action( 'admin_notices', 'wp_tweaks_add_debug_warning', 5 );
function wp_tweaks_add_debug_warning () {
	if ( ! current_user_can( 'administrator' ) ) return;
	$wp_debug = defined( 'WP_DEBUG' ) ? WP_DEBUG : false;
	$save_queries = defined( 'SAVEQUERIES' ) ? SAVEQUERIES : false;
	if ( $wp_debug || $save_queries ) {
		$title = esc_html__( 'Caution!', 'wp-tweaks' );
		$message = esc_html__( 'The following WordPress constants are enabled and it is highly recommended that you disable them in production environments.', 'wp-tweaks' );
		$content = "<strong>$title</strong><br>$message<br>";
		$constants = [ 'WP_DEBUG', 'SAVEQUERIES' ];
		if ( $wp_debug ) {
			$constants[] = 'WP_DEBUG_LOG';
			$constants[] = 'WP_DEBUG_DISPLAY';
		}
		$constants[] = 'SCRIPT_DEBUG';

		foreach ( $constants as $name ) {
			if ( defined( $name ) && constant( $name ) ) {
				$content .= '<span class="wpt_constant">' . esc_html( $name ) . "</span>";
			}
		}
		?>
		<style>
			.wpt_notice {
				border-left-color: #fab005;
			}
			.wpt_constant {
				font-family: monospace;
				color: #e67700;
				background-color: #fff3bf;
				line-height: 1;
				font-weight: 700;
				display: inline-block;
				padding: 0.25rem 0.5rem;
				margin-right: .5rem;
				margin-top: .5rem;
				border-radius: 4px;
			}
		</style>
		<div class='notice notice-warning wpt_notice'><p><?php echo $content ?></p></div>
		<?php
	}
}
