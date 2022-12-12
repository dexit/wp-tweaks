<?php
/**
 * Change admin footer text
 *
 * @package wp-tweaks
 */

add_filter( 'admin_footer_text', 'wp_tweaks_custom_admin_footer_text' );
function wp_tweaks_custom_admin_footer_text ( $content ) {
	$text = WP_Tweaks_Settings::get_option( 'custom-admin-footer-text' );
	if ( $text ) {
		$placeholders = apply_filters( 'wp_tweaks_admin_footer_placeholders', [
			'{current_year}' => date('Y'),
			'{site_name}' => get_bloginfo('name')
		] );
		foreach ( $placeholders as $placeholder => $value ) {
			$text = str_replace( $placeholder, $value, $text );
		}
		$content = apply_filters( 'wp_tweaks_admin_footer_text', $text );
	}
	return $content;
}
