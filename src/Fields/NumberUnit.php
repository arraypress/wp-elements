<?php
/**
 * NumberUnit Field Class
 *
 * Combined number input with unit selector.
 * Useful for measurements like "10 px", "50 %", "2 rem", etc.
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
 * Class NumberUnit
 *
 * Number with unit selector field.
 */
class NumberUnit extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'units'        => [
				'px'  => 'px',
				'%'   => '%',
				'em'  => 'em',
				'rem' => 'rem',
			],
			'default_unit' => 'px',
			'min'          => null,
			'max'          => null,
			'step'         => 1,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value        = is_array( $this->value ) ? $this->value : [];
		$number_value = $value['value'] ?? '';
		$unit_value   = $value['unit'] ?? $this->options['default_unit'];

		$html = '<div class="number-unit-field">';

		// Number input
		$number_attrs = [
			'type'  => 'number',
			'id'    => $this->options['id'] . '_value',
			'name'  => $this->name . '[value]',
			'value' => $number_value,
			'class' => 'small-text number-unit-field__value',
			'step'  => $this->options['step'],
		];

		if ( $this->options['min'] !== null ) {
			$number_attrs['min'] = $this->options['min'];
		}

		if ( $this->options['max'] !== null ) {
			$number_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$number_attrs['disabled'] = true;
		}

		if ( $this->options['required'] ) {
			$number_attrs['required'] = true;
		}

		if ( ! empty( $this->options['placeholder'] ) ) {
			$number_attrs['placeholder'] = $this->options['placeholder'];
		}

		$html .= Element::create( 'input', $number_attrs )->render();

		// Unit select
		$unit_attrs = [
			'id'    => $this->options['id'] . '_unit',
			'name'  => $this->name . '[unit]',
			'class' => 'number-unit-field__unit',
		];

		if ( $this->options['disabled'] ) {
			$unit_attrs['disabled'] = true;
		}

		$options_html = '';
		foreach ( $this->options['units'] as $key => $label ) {
			$selected     = ( (string) $key === (string) $unit_value );
			$options_html .= Element::create( 'option', [
				'value'    => $key,
				'selected' => $selected,
			], esc_html( $label ) )->render();
		}

		$html .= Element::create( 'select', $unit_attrs, $options_html )->render();

		$html .= '</div>';

		return $html;
	}

}
