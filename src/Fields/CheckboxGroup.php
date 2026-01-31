<?php
/**
 * CheckboxGroup Field Class
 *
 * Multiple checkboxes for selecting multiple values.
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
 * Class CheckboxGroup
 *
 * Multiple checkbox selection field.
 */
class CheckboxGroup extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'options' => [],
			'layout'  => 'vertical', // vertical or horizontal
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$values       = $this->get_selected_values();
		$layout_class = 'checkbox-group checkbox-group--' . $this->options['layout'];

		$html = '<div class="' . esc_attr( $layout_class ) . '">';

		foreach ( $this->options['options'] as $key => $label ) {
			$checkbox_id = $this->options['id'] . '_' . $this->sanitize_id( (string) $key );
			$checked     = in_array( (string) $key, $values, true );

			// Handle option as array
			if ( is_array( $label ) ) {
				$option_label    = $label['label'] ?? $key;
				$option_disabled = ! empty( $label['disabled'] );
			} else {
				$option_label    = $label;
				$option_disabled = false;
			}

			$attrs = [
				'type'     => 'checkbox',
				'id'       => $checkbox_id,
				'name'     => $this->name . '[]',
				'value'    => $key,
				'checked'  => $checked,
				'disabled' => $option_disabled || $this->options['disabled'],
			];

			$input = Element::create( 'input', $attrs )->render();

			$html .= sprintf(
				'<label class="checkbox-item" for="%s">%s <span class="checkbox-label">%s</span></label>',
				esc_attr( $checkbox_id ),
				$input,
				esc_html( $option_label )
			);
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Get selected values as array of strings
	 *
	 * @return array
	 */
	protected function get_selected_values(): array {
		if ( $this->value === null || $this->value === '' ) {
			return [];
		}

		$values = is_array( $this->value ) ? $this->value : [ $this->value ];

		return array_map( 'strval', $values );
	}

}
