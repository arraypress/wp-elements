<?php
/**
 * Date Field Class
 *
 * HTML5 date input field.
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
 * Class Date
 *
 * Date picker input field.
 */
class Date extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'min' => null,
			'max' => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = $this->build_attributes( [
			'type'  => 'date',
			'value' => $this->value ?? '',
		] );

		// Remove placeholder (not always supported for date)
		unset( $attrs['placeholder'] );

		// Add min/max if set
		if ( $this->options['min'] !== null ) {
			$attrs['min'] = $this->options['min'];
		}

		if ( $this->options['max'] !== null ) {
			$attrs['max'] = $this->options['max'];
		}

		return Element::create( 'input', $attrs )->render();
	}

}
