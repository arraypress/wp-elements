<?php
/**
 * WP Elements Helper Functions
 *
 * Minimal helper functions for asset loading and field rendering.
 *
 * @package     ArrayPress\Elements
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

use ArrayPress\Elements\Fields;

if ( ! function_exists( 'wp_render_field' ) ):
	/**
	 * Create and render a field by type.
	 *
	 * @param string $type    Field type (text, select, checkbox, etc.).
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return string Rendered HTML.
	 */
	function wp_render_field( string $type, string $name, $value = null, array $options = [] ): string {
		$field = Fields::create( $type, $name, $value, $options );

		return $field ? $field->render() : '';
	}
endif;

if ( ! function_exists( 'wp_elements_enqueue' ) ):
	/**
	 * Enqueue WP Elements CSS and JavaScript.
	 *
	 * Call this in your admin_enqueue_scripts hook.
	 *
	 * @return bool True if both succeeded, false if either failed.
	 */
	function wp_elements_enqueue(): bool {
		$css = wp_enqueue_composer_style(
			'wp-elements',
			__FILE__,
			'css/wp-elements.css'
		);

		$js = wp_enqueue_composer_script(
			'wp-elements',
			__FILE__,
			'js/wp-elements.js',
			[]
		);

		return $css && $js;
	}
endif;