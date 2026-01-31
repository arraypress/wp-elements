<?php
/**
 * Color Field Class
 *
 * Color picker input using HTML5 color type.
 *
 * @package     ArrayPress\Elements\Fields
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\Elements\Fields;

use ArrayPress\Elements\Element;
use ArrayPress\Elements\Field;

/**
 * Class Color
 *
 * Color picker input field.
 */
class Color extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'default' => '#000000',
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value = $this->value ?: $this->options['default'];

		$attrs = $this->build_attributes( [
			'type'  => 'color',
			'value' => $value,
		] );

		// Remove placeholder (not valid for color)
		unset( $attrs['placeholder'] );

		// Add default color as data attribute for potential JS reset
		if ( ! isset( $attrs['data'] ) ) {
			$attrs['data'] = [];
		}
		$attrs['data']['default-color'] = $this->options['default'];

		return Element::create( 'input', $attrs )->render();
	}

}
