<?php
/**
 * Select Field Class
 *
 * Dropdown select field with single/multiple selection and optgroup support.
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
 * Class Select
 *
 * Dropdown select field.
 */
class Select extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'options'     => [],
			'multiple'    => false,
			'size'        => null,
			'placeholder' => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$name = $this->options['multiple'] ? $this->name . '[]' : $this->name;

		$attrs = $this->build_attributes( [
			'name' => $name,
		] );

		// Remove placeholder from attrs (it's handled as an option)
		unset( $attrs['placeholder'] );

		// Add multiple attribute
		if ( $this->options['multiple'] ) {
			$attrs['multiple'] = true;
		}

		// Add size attribute
		if ( $this->options['size'] !== null ) {
			$attrs['size'] = $this->options['size'];
		}

		// Build options HTML
		$options_html = $this->render_options();

		return Element::create( 'select', $attrs, $options_html )->render();
	}

	/**
	 * Render select options
	 *
	 * @return string
	 */
	protected function render_options(): string {
		$html   = '';
		$values = $this->get_selected_values();

		// Add placeholder option if set
		if ( $this->options['placeholder'] !== null ) {
			$html .= Element::create( 'option', [
				'value'    => '',
				'disabled' => ! $this->options['multiple'],
				'selected' => empty( $values ),
			], esc_html( $this->options['placeholder'] ) )->render();
		}

		// Render options
		foreach ( $this->options['options'] as $key => $value ) {
			// Check if this is an optgroup
			if ( is_array( $value ) && isset( $value['options'] ) ) {
				$html .= $this->render_optgroup( $key, $value );
			} elseif ( is_array( $value ) && ! isset( $value['label'] ) ) {
				// Simple optgroup: key => [ value => label, ... ]
				$html .= $this->render_optgroup( $key, [ 'options' => $value ] );
			} else {
				$html .= $this->render_option( $key, $value, $values );
			}
		}

		return $html;
	}

	/**
	 * Render an optgroup
	 *
	 * @param string $label    Optgroup label.
	 * @param array  $optgroup Optgroup configuration.
	 *
	 * @return string
	 */
	protected function render_optgroup( string $label, array $optgroup ): string {
		$attrs = [ 'label' => $label ];

		if ( ! empty( $optgroup['disabled'] ) ) {
			$attrs['disabled'] = true;
		}

		$options_html = '';
		$values       = $this->get_selected_values();

		foreach ( $optgroup['options'] as $key => $value ) {
			$options_html .= $this->render_option( $key, $value, $values );
		}

		return Element::create( 'optgroup', $attrs, $options_html )->render();
	}

	/**
	 * Render a single option
	 *
	 * @param mixed $key    Option value.
	 * @param mixed $value  Option label or configuration array.
	 * @param array $values Currently selected values.
	 *
	 * @return string
	 */
	protected function render_option( $key, $value, array $values ): string {
		// Handle option as array with label and optional attributes
		if ( is_array( $value ) ) {
			$label    = $value['label'] ?? $key;
			$disabled = ! empty( $value['disabled'] );
		} else {
			$label    = $value;
			$disabled = false;
		}

		$attrs = [
			'value'    => $key,
			'selected' => in_array( (string) $key, $values, true ),
		];

		if ( $disabled ) {
			$attrs['disabled'] = true;
		}

		return Element::create( 'option', $attrs, esc_html( $label ) )->render();
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
