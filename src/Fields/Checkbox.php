<?php
/**
 * Checkbox Field Class
 *
 * Single boolean checkbox field.
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
 * Class Checkbox
 *
 * Single boolean checkbox field.
 */
class Checkbox extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'checkbox_value' => '1',
			'checkbox_label' => null,
		];
	}

	/**
	 * Render the complete field
	 *
	 * Checkbox has special layout with label after input.
	 *
	 * @return string
	 */
	public function render(): string {
		if ( ! $this->options['wrapper'] ) {
			return $this->render_input();
		}

		$html = '<div class="' . esc_attr( $this->get_wrapper_class() ) . '">';

		// For checkboxes, we wrap the input and label together
		$html .= $this->render_input();

		// Description comes after
		if ( ! empty( $this->options['description'] ) ) {
			$html .= $this->render_description();
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$checked = ! empty( $this->value );

		$attrs = $this->build_attributes( [
			'type'    => 'checkbox',
			'value'   => $this->options['checkbox_value'],
			'checked' => $checked,
		] );

		// Remove placeholder (not valid for checkbox)
		unset( $attrs['placeholder'] );

		$input = Element::create( 'input', $attrs )->render();

		// Get the label text
		$label_text = $this->options['checkbox_label'] ?? $this->options['label'] ?? '';

		// If we have label text, wrap in label element
		if ( ! empty( $label_text ) ) {
			return sprintf(
				'<label for="%s">%s %s</label>',
				esc_attr( $this->options['id'] ),
				$input,
				esc_html( $label_text )
			);
		}

		return $input;
	}

	/**
	 * Render the field label
	 *
	 * Checkbox label is rendered inline with input, so this returns empty.
	 *
	 * @return string
	 */
	protected function render_label(): string {
		return '';
	}

}
