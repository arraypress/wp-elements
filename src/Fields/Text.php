<?php
/**
 * Text Field Class
 *
 * Handles text-based input types: text, url, email, tel, password.
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
 * Class Text
 *
 * Text input field supporting multiple input types.
 */
class Text extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'type'      => 'text',
			'maxlength' => null,
			'minlength' => null,
			'pattern'   => null,
			'size'      => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = $this->build_attributes( [
			'type'  => $this->options['type'],
			'value' => $this->value ?? '',
		] );

		// Add optional attributes
		foreach ( [ 'maxlength', 'minlength', 'pattern', 'size' ] as $attr ) {
			if ( $this->options[ $attr ] !== null ) {
				$attrs[ $attr ] = $this->options[ $attr ];
			}
		}

		// Add default class based on type
		if ( empty( $attrs['class'] ) ) {
			$attrs['class'] = 'regular-text';
		}

		return Element::create( 'input', $attrs )->render();
	}

	/**
	 * Get the field type identifier
	 *
	 * @return string
	 */
	protected function get_type(): string {
		return $this->options['type'];
	}

}
