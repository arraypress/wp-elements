<?php
/**
 * WP Elements Helper Functions
 *
 * Provides convenient functions for enqueueing the library's assets.
 *
 * @package     ArrayPress\Elements
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

if ( ! function_exists( 'wp_elements_enqueue_styles' ) ):
	/**
	 * Enqueue the WP Elements CSS.
	 *
	 * Call this in your admin_enqueue_scripts hook to load the
	 * structural CSS needed for toggle switches, button groups,
	 * range sliders, and compound fields.
	 *
	 * @return bool True on success, false on failure.
	 */
	function wp_elements_enqueue_styles(): bool {
		return wp_enqueue_composer_style(
			'wp-elements',
			__FILE__,
			'css/wp-elements.css'
		);
	}
endif;

if ( ! function_exists( 'wp_elements_enqueue_scripts' ) ):
	/**
	 * Enqueue the WP Elements JavaScript.
	 *
	 * Call this in your admin_enqueue_scripts hook to load the
	 * JavaScript for button group selection state and range
	 * slider live output updates.
	 *
	 * Note: The fields work without JS, but this improves UX.
	 *
	 * @return bool True on success, false on failure.
	 */
	function wp_elements_enqueue_scripts(): bool {
		return wp_enqueue_composer_script(
			'wp-elements',
			__FILE__,
			'js/wp-elements.js',
			[],
			false,
			true
		);
	}
endif;

if ( ! function_exists( 'wp_elements_enqueue_assets' ) ):
	/**
	 * Enqueue both WP Elements CSS and JavaScript.
	 *
	 * Convenience function to enqueue all assets at once.
	 *
	 * @return bool True if both succeeded, false if either failed.
	 */
	function wp_elements_enqueue_assets(): bool {
		$css = wp_elements_enqueue_styles();
		$js  = wp_elements_enqueue_scripts();

		return $css && $js;
	}
endif;

if ( ! function_exists( 'wp_elements_register_styles' ) ):
	/**
	 * Register (but don't enqueue) the WP Elements CSS.
	 *
	 * Use this if you want to register the styles for later
	 * conditional enqueueing.
	 *
	 * @return bool True on success, false on failure.
	 */
	function wp_elements_register_styles(): bool {
		return wp_register_composer_style(
			'wp-elements',
			__FILE__,
			'css/wp-elements.css'
		);
	}
endif;

if ( ! function_exists( 'wp_elements_register_scripts' ) ):
	/**
	 * Register (but don't enqueue) the WP Elements JavaScript.
	 *
	 * Use this if you want to register the script for later
	 * conditional enqueueing.
	 *
	 * @return bool True on success, false on failure.
	 */
	function wp_elements_register_scripts(): bool {
		return wp_register_composer_script(
			'wp-elements',
			__FILE__,
			'js/wp-elements.js',
			[],
			false,
			true
		);
	}
endif;

if ( ! function_exists( 'wp_elements_register_assets' ) ):
	/**
	 * Register (but don't enqueue) both WP Elements CSS and JavaScript.
	 *
	 * Convenience function to register all assets at once.
	 *
	 * @return bool True if both succeeded, false if either failed.
	 */
	function wp_elements_register_assets(): bool {
		$css = wp_elements_register_styles();
		$js  = wp_elements_register_scripts();

		return $css && $js;
	}
endif;
