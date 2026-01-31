<?php
/**
 * ButtonGroup Field Class
 *
 * Toggle button group for single or multiple selection.
 * Uses hidden radio/checkbox inputs with styled button labels.
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
 * Class ButtonGroup
 *
 * Toggle button group field.
 */
class ButtonGroup extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'options'  => [],
			'multiple' => false,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$values      = $this->get_selected_values();
		$multiple    = $this->options['multiple'];
		$input_type  = $multiple ? 'checkbox' : 'radio';
		$name        = $multiple ? $this->name . '[]' : $this->name;
		$group_class = 'button-group' . ( $multiple ? ' button-group--multiple' : '' );

		$html = '<div class="' . esc_attr( $group_class ) . '">';

		foreach ( $this->options['options'] as $key => $label ) {
			$button_id   = $this->options['id'] . '_' . $this->sanitize_id( (string) $key );
			$is_selected = in_array( (string) $key, $values, true );

			// Handle option as array
			if ( is_array( $label ) ) {
				$option_label    = $label['label'] ?? $key;
				$option_disabled = ! empty( $label['disabled'] );
			} else {
				$option_label    = $label;
				$option_disabled = false;
			}

			$label_class = 'button-group__item' . ( $is_selected ? ' is-selected' : '' );

			$attrs = [
				'type'     => $input_type,
				'id'       => $button_id,
				'name'     => $name,
				'value'    => $key,
				'checked'  => $is_selected,
				'disabled' => $option_disabled || $this->options['disabled'],
				'class'    => 'button-group__input',
			];

			$input = Element::create( 'input', $attrs )->render();

			$html .= sprintf(
				'<label class="%s" for="%s">%s<span class="button-group__label">%s</span></label>',
				esc_attr( $label_class ),
				esc_attr( $button_id ),
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
