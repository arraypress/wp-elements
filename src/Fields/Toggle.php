<?php
/**
 * Toggle Field Class
 *
 * Visual toggle switch (styled checkbox alternative).
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
 * Class Toggle
 *
 * Visual toggle switch field.
 */
class Toggle extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'on_label'  => '',
			'off_label' => '',
		];
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
			'value'   => '1',
			'checked' => $checked,
			'class'   => 'toggle__input',
		] );

		// Remove placeholder (not valid for checkbox)
		unset( $attrs['placeholder'] );

		$input = Element::create( 'input', $attrs )->render();

		$html = '<div class="toggle-field">';

		// Toggle switch wrapper
		$html .= '<label class="toggle" for="' . esc_attr( $this->options['id'] ) . '">';
		$html .= $input;
		$html .= '<span class="toggle__slider"></span>';
		$html .= '</label>';

		// On/Off labels if provided
		$show_labels = ! empty( $this->options['on_label'] ) || ! empty( $this->options['off_label'] );

		if ( $show_labels ) {
			$html .= '<span class="toggle__labels">';
			$html .= '<span class="toggle__label-off">' . esc_html( $this->options['off_label'] ) . '</span>';
			$html .= '<span class="toggle__label-on">' . esc_html( $this->options['on_label'] ) . '</span>';
			$html .= '</span>';
		}

		// Text label if set and different from on/off labels
		if ( ! empty( $this->options['label'] ) && ! $show_labels ) {
			$html .= '<span class="toggle__text">' . esc_html( $this->options['label'] ) . '</span>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Render the field label
	 *
	 * Toggle label is rendered inline, so main label is empty unless specified.
	 *
	 * @return string
	 */
	protected function render_label(): string {
		// Only render separate label if both on/off labels exist
		// (meaning the main label should be a separate heading)
		if ( ! empty( $this->options['on_label'] ) && ! empty( $this->options['off_label'] ) ) {
			return parent::render_label();
		}

		return '';
	}

}
