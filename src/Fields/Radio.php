<?php
/**
 * Radio Field Class
 *
 * Radio button group for single selection from multiple options.
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
 * Class Radio
 *
 * Radio button group field.
 */
class Radio extends Field {

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
		$current_value = (string) ( $this->value ?? '' );
		$layout_class  = 'radio-group radio-group--' . $this->options['layout'];

		$html = '<div class="' . esc_attr( $layout_class ) . '">';

		foreach ( $this->options['options'] as $key => $label ) {
			$radio_id = $this->options['id'] . '_' . $this->sanitize_id( (string) $key );
			$checked  = ( (string) $key === $current_value );

			// Handle option as array
			if ( is_array( $label ) ) {
				$option_label    = $label['label'] ?? $key;
				$option_disabled = ! empty( $label['disabled'] );
			} else {
				$option_label    = $label;
				$option_disabled = false;
			}

			$attrs = [
				'type'     => 'radio',
				'id'       => $radio_id,
				'name'     => $this->name,
				'value'    => $key,
				'checked'  => $checked,
				'disabled' => $option_disabled || $this->options['disabled'],
			];

			$input = Element::create( 'input', $attrs )->render();

			$html .= sprintf(
				'<label class="radio-item" for="%s">%s <span class="radio-label">%s</span></label>',
				esc_attr( $radio_id ),
				$input,
				esc_html( $option_label )
			);
		}

		$html .= '</div>';

		return $html;
	}

}
