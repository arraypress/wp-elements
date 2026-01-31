<?php
/**
 * Textarea Field Class
 *
 * Multi-line text input field.
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
 * Class Textarea
 *
 * Multi-line text input field.
 */
class Textarea extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'rows'      => 5,
			'cols'      => null,
			'maxlength' => null,
			'minlength' => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = $this->build_attributes( [
			'rows' => $this->options['rows'],
		] );

		// Add optional attributes
		foreach ( [ 'cols', 'maxlength', 'minlength' ] as $attr ) {
			if ( $this->options[ $attr ] !== null ) {
				$attrs[ $attr ] = $this->options[ $attr ];
			}
		}

		// Add default class
		if ( empty( $attrs['class'] ) ) {
			$attrs['class'] = 'large-text';
		}

		// Content needs to be escaped
		$content = esc_textarea( $this->value ?? '' );

		return Element::create( 'textarea', $attrs, $content )->render();
	}

}
