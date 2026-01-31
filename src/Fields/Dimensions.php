<?php
/**
 * Dimensions Field Class
 *
 * Combined width × height input field.
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
 * Class Dimensions
 *
 * Width × Height dimension input field.
 */
class Dimensions extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'width_label'  => 'Width',
			'height_label' => 'Height',
			'separator'    => '×',
			'unit'         => '',
			'min'          => 0,
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
		$width_value  = $value['width'] ?? '';
		$height_value = $value['height'] ?? '';

		$html = '<div class="dimensions-field">';

		// Width field
		$html .= '<div class="dimensions__input-group">';
		$html .= '<label class="dimensions__label" for="' . esc_attr( $this->options['id'] ) . '_width">';
		$html .= esc_html( $this->options['width_label'] );
		$html .= '</label>';

		$width_attrs = [
			'type'  => 'number',
			'id'    => $this->options['id'] . '_width',
			'name'  => $this->name . '[width]',
			'value' => $width_value,
			'class' => 'small-text',
			'min'   => $this->options['min'],
			'step'  => $this->options['step'],
		];

		if ( $this->options['max'] !== null ) {
			$width_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$width_attrs['disabled'] = true;
		}

		$html .= Element::create( 'input', $width_attrs )->render();
		$html .= '</div>';

		// Separator
		$html .= '<span class="dimensions__separator">' . esc_html( $this->options['separator'] ) . '</span>';

		// Height field
		$html .= '<div class="dimensions__input-group">';
		$html .= '<label class="dimensions__label" for="' . esc_attr( $this->options['id'] ) . '_height">';
		$html .= esc_html( $this->options['height_label'] );
		$html .= '</label>';

		$height_attrs = [
			'type'  => 'number',
			'id'    => $this->options['id'] . '_height',
			'name'  => $this->name . '[height]',
			'value' => $height_value,
			'class' => 'small-text',
			'min'   => $this->options['min'],
			'step'  => $this->options['step'],
		];

		if ( $this->options['max'] !== null ) {
			$height_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$height_attrs['disabled'] = true;
		}

		$html .= Element::create( 'input', $height_attrs )->render();
		$html .= '</div>';

		// Unit suffix
		if ( ! empty( $this->options['unit'] ) ) {
			$html .= '<span class="dimensions__unit">' . esc_html( $this->options['unit'] ) . '</span>';
		}

		$html .= '</div>';

		return $html;
	}

}
