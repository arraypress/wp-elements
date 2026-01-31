<?php
/**
 * Price Field Class
 *
 * Combined amount input with currency selector.
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
 * Class Price
 *
 * Price field with amount and currency.
 */
class Price extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'currencies'        => [
				'USD' => '$',
				'EUR' => '€',
				'GBP' => '£',
			],
			'default_currency'  => 'USD',
			'min'               => 0,
			'max'               => null,
			'step'              => '0.01',
			'currency_position' => 'before', // before or after
			'show_currency'     => true,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value          = is_array( $this->value ) ? $this->value : [];
		$amount_value   = $value['amount'] ?? '';
		$currency_value = $value['currency'] ?? $this->options['default_currency'];

		$html = '<div class="price-field">';

		// Build amount input
		$amount_attrs = [
			'type'        => 'number',
			'id'          => $this->options['id'] . '_amount',
			'name'        => $this->name . '[amount]',
			'value'       => $amount_value,
			'class'       => 'small-text price-field__amount',
			'min'         => $this->options['min'],
			'step'        => $this->options['step'],
			'placeholder' => '0.00',
		];

		if ( $this->options['max'] !== null ) {
			$amount_attrs['max'] = $this->options['max'];
		}

		if ( $this->options['disabled'] ) {
			$amount_attrs['disabled'] = true;
		}

		if ( $this->options['required'] ) {
			$amount_attrs['required'] = true;
		}

		$amount_input = Element::create( 'input', $amount_attrs )->render();

		// Build currency select (if showing currency)
		$currency_select = '';
		if ( $this->options['show_currency'] ) {
			$currency_attrs = [
				'id'    => $this->options['id'] . '_currency',
				'name'  => $this->name . '[currency]',
				'class' => 'price-field__currency',
			];

			if ( $this->options['disabled'] ) {
				$currency_attrs['disabled'] = true;
			}

			$options_html = '';
			foreach ( $this->options['currencies'] as $code => $symbol ) {
				$selected     = ( (string) $code === (string) $currency_value );
				$label        = $symbol !== $code ? "{$code} ({$symbol})" : $code;
				$options_html .= Element::create( 'option', [
					'value'    => $code,
					'selected' => $selected,
				], esc_html( $label ) )->render();
			}

			$currency_select = Element::create( 'select', $currency_attrs, $options_html )->render();
		}

		// Render based on currency position
		if ( $this->options['currency_position'] === 'before' ) {
			$html .= $currency_select . $amount_input;
		} else {
			$html .= $amount_input . $currency_select;
		}

		$html .= '</div>';

		return $html;
	}

}
