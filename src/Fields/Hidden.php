<?php
/**
 * Hidden Field Class
 *
 * Hidden input field for storing values not visible to users.
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
 * Class Hidden
 *
 * Hidden input field.
 */
class Hidden extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'wrapper' => false, // Hidden fields don't need wrappers
		];
	}

	/**
	 * Render the complete field
	 *
	 * Hidden fields are always rendered without wrapper.
	 *
	 * @return string
	 */
	public function render(): string {
		return $this->render_input();
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$attrs = [
			'type'  => 'hidden',
			'id'    => $this->options['id'],
			'name'  => $this->name,
			'value' => $this->value ?? '',
		];

		// Add data attributes
		if ( ! empty( $this->options['data'] ) ) {
			$attrs['data'] = $this->options['data'];
		}

		// Add custom attributes
		if ( ! empty( $this->options['attrs'] ) ) {
			$attrs['attrs'] = $this->options['attrs'];
		}

		return Element::create( 'input', $attrs )->render();
	}

}
