<?php
/**
 * AmountType Field Class
 *
 * Combined numeric input with type selector dropdown.
 * Useful for discounts (amount + percent/flat), durations, etc.
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
 * Class AmountType
 *
 * Amount with type selector field.
 */
class AmountType extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'type_options' => [],
			'type_default' => null,
			'min'          => 0,
			'max'          => null,
			'step'         => 'any',
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value        = is_array( $this->value ) ? $this->value : [];
		$amount_value = $value['amount'] ?? '';
		$type_value   = $value['type'] ?? $this->options['type_default'] ?? '';

		$html = '<div class="amount-type-field">';

		// Amount input
		$amount_attrs = [
			'type'  => 'number',
			'id'    => $this->options['id'] . '_amount',
			'name'  => $this->name . '[amount]',
			'value' => $amount_value,
			'class' => 'small-text',
			'min'   => $this->options['min'],
			'step'  => $this->options['step'],
		];

		if ( $this->options['max'] !== null ) {
			$amount_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$amount_attrs['disabled'] = true;
		}

		if ( $this->options['required'] ) {
			$amount_attrs['required'] = true;
		}

		$html .= Element::create( 'input', $amount_attrs )->render();

		// Type select
		$type_attrs = [
			'id'   => $this->options['id'] . '_type',
			'name' => $this->name . '[type]',
		];

		if ( $this->options['disabled'] ) {
			$type_attrs['disabled'] = true;
		}

		$options_html = '';
		foreach ( $this->options['type_options'] as $key => $label ) {
			$selected     = ( (string) $key === (string) $type_value );
			$options_html .= Element::create( 'option', [
				'value'    => $key,
				'selected' => $selected,
			], esc_html( $label ) )->render();
		}

		$html .= Element::create( 'select', $type_attrs, $options_html )->render();

		$html .= '</div>';

		return $html;
	}

}
