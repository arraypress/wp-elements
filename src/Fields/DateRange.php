<?php
/**
 * DateRange Field Class
 *
 * Two date inputs for start and end date selection.
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
 * Class DateRange
 *
 * Date range picker with start and end dates.
 */
class DateRange extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'start_label' => 'Start',
			'end_label'   => 'End',
			'separator'   => '—',
			'min'         => null,
			'max'         => null,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value       = is_array( $this->value ) ? $this->value : [];
		$start_value = $value['start'] ?? '';
		$end_value   = $value['end'] ?? '';

		$html = '<div class="range-picker date-range">';

		// Start date field
		$html .= '<div class="range-picker__field">';
		$html .= '<label class="range-picker__label" for="' . esc_attr( $this->options['id'] ) . '_start">';
		$html .= esc_html( $this->options['start_label'] );
		$html .= '</label>';

		$start_attrs = [
			'type'  => 'date',
			'id'    => $this->options['id'] . '_start',
			'name'  => $this->name . '[start]',
			'value' => $start_value,
			'class' => 'range-picker__input',
		];

		if ( $this->options['min'] !== null ) {
			$start_attrs['min'] = $this->options['min'];
		}

		if ( $this->options['max'] !== null ) {
			$start_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$start_attrs['disabled'] = true;
		}

		$html .= Element::create( 'input', $start_attrs )->render();
		$html .= '</div>';

		// Separator
		$html .= '<span class="range-picker__separator">' . esc_html( $this->options['separator'] ) . '</span>';

		// End date field
		$html .= '<div class="range-picker__field">';
		$html .= '<label class="range-picker__label" for="' . esc_attr( $this->options['id'] ) . '_end">';
		$html .= esc_html( $this->options['end_label'] );
		$html .= '</label>';

		$end_attrs = [
			'type'  => 'date',
			'id'    => $this->options['id'] . '_end',
			'name'  => $this->name . '[end]',
			'value' => $end_value,
			'class' => 'range-picker__input',
		];

		if ( $this->options['min'] !== null ) {
			$end_attrs['min'] = $this->options['min'];
		}

		if ( $this->options['max'] !== null ) {
			$end_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$end_attrs['disabled'] = true;
		}

		$html .= Element::create( 'input', $end_attrs )->render();
		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}

}
