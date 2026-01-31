<?php
/**
 * DateTime Field Class
 *
 * HTML5 datetime-local input field.
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
 * Class DateTime
 *
 * DateTime picker input field.
 */
class DateTime extends Field {

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
			'type'  => 'datetime-local',
			'value' => $this->value ?? '',
		] );

		// Remove placeholder (not supported for datetime-local)
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
