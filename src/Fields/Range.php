<?php
/**
 * Range Field Class
 *
 * Range slider input with optional output display.
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
 * Class Range
 *
 * Range slider input field.
 */
class Range extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'min'         => 0,
			'max'         => 100,
			'step'        => 1,
			'unit'        => '',
			'show_output' => true,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value = $this->value !== null && $this->value !== ''
			? $this->value
			: $this->options['min'];

		$attrs = $this->build_attributes( [
			'type'  => 'range',
			'value' => $value,
			'min'   => $this->options['min'],
			'max'   => $this->options['max'],
			'step'  => $this->options['step'],
		] );

		$unit = esc_attr( $this->options['unit'] );
		$html = '<div class="range-field-wrapper" data-unit="' . $unit . '">';
		$html .= Element::create( 'input', $attrs )->render();

		// Add output element if enabled
		if ( $this->options['show_output'] ) {
			$output_attrs = [
				'for'   => $this->options['id'],
				'class' => 'range-output',
			];

			$display_value = $value . $this->options['unit'];
			$html          .= Element::create( 'output', $output_attrs, esc_html( $display_value ) )->render();
		}

		$html .= '</div>';

		return $html;
	}

}
