<?php
/**
 * Number Field Class
 *
 * Numeric input field with min, max, and step support.
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
 * Class Number
 *
 * Numeric input field.
 */
class Number extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'min'  => null,
			'max'  => null,
			'step' => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = $this->build_attributes( [
			'type'  => 'number',
			'value' => $this->value ?? '',
		] );

		// Add optional numeric attributes
		foreach ( [ 'min', 'max', 'step' ] as $attr ) {
			if ( $this->options[ $attr ] !== null ) {
				$attrs[ $attr ] = $this->options[ $attr ];
			}
		}

		// Add default class
		if ( empty( $attrs['class'] ) ) {
			$attrs['class'] = 'small-text';
		}

		return Element::create( 'input', $attrs )->render();
	}

}
