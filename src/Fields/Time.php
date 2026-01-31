<?php
/**
 * Time Field Class
 *
 * HTML5 time input field.
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
 * Class Time
 *
 * Time picker input field.
 */
class Time extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'min'  => null,
			'max'  => null,
			'step' => null, // In seconds (e.g., 60 for minute intervals)
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = $this->build_attributes( [
			'type'  => 'time',
			'value' => $this->value ?? '',
		] );

		// Remove placeholder (not always supported for time)
		unset( $attrs['placeholder'] );

		// Add min/max/step if set
		foreach ( [ 'min', 'max', 'step' ] as $attr ) {
			if ( $this->options[ $attr ] !== null ) {
				$attrs[ $attr ] = $this->options[ $attr ];
			}
		}

		return Element::create( 'input', $attrs )->render();
	}

}
