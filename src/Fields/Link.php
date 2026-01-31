<?php
/**
 * Link Field Class
 *
 * Combined URL, title, and target fields for creating links.
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
 * Class Link
 *
 * Link field with URL, title, and target options.
 */
class Link extends Field {

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'url_label'       => 'URL',
			'url_placeholder' => 'https://',
			'title_label'     => 'Link Text',
			'target_label'    => 'Open in new tab',
			'show_title'      => true,
			'show_target'     => true,
		];
	}

	/**
	 * Render the input element
	 *
	 * @return string
	 */
	public function render_input(): string {
		$value  = is_array( $this->value ) ? $this->value : [];
		$url    = $value['url'] ?? '';
		$title  = $value['title'] ?? '';
		$target = $value['target'] ?? '';

		$html = '<div class="link-field">';

		// URL field
		$html .= '<div class="link-field__row">';
		$html .= '<label class="link-field__label" for="' . esc_attr( $this->options['id'] ) . '_url">';
		$html .= esc_html( $this->options['url_label'] );
		$html .= '</label>';

		$url_attrs = [
			'type'        => 'url',
			'id'          => $this->options['id'] . '_url',
			'name'        => $this->name . '[url]',
			'value'       => $url,
			'class'       => 'regular-text link-field__url',
			'placeholder' => $this->options['url_placeholder'],
		];

		if ( $this->options['disabled'] ) {
			$url_attrs['disabled'] = true;
		}

		if ( $this->options['required'] ) {
			$url_attrs['required'] = true;
		}

		$html .= Element::create( 'input', $url_attrs )->render();
		$html .= '</div>';

		// Title field
		if ( $this->options['show_title'] ) {
			$html .= '<div class="link-field__row">';
			$html .= '<label class="link-field__label" for="' . esc_attr( $this->options['id'] ) . '_title">';
			$html .= esc_html( $this->options['title_label'] );
			$html .= '</label>';

			$title_attrs = [
				'type'        => 'text',
				'id'          => $this->options['id'] . '_title',
				'name'        => $this->name . '[title]',
				'value'       => $title,
				'class'       => 'regular-text link-field__title',
				'placeholder' => $this->options['title_label'],
			];

			if ( $this->options['disabled'] ) {
				$title_attrs['disabled'] = true;
			}

			$html .= Element::create( 'input', $title_attrs )->render();
			$html .= '</div>';
		}

		// Target checkbox
		if ( $this->options['show_target'] ) {
			$html .= '<div class="link-field__row link-field__row--checkbox">';

			$target_attrs = [
				'type'    => 'checkbox',
				'id'      => $this->options['id'] . '_target',
				'name'    => $this->name . '[target]',
				'value'   => '_blank',
				'checked' => ( $target === '_blank' ),
			];

			if ( $this->options['disabled'] ) {
				$target_attrs['disabled'] = true;
			}

			$checkbox = Element::create( 'input', $target_attrs )->render();

			$html .= '<label for="' . esc_attr( $this->options['id'] ) . '_target">';
			$html .= $checkbox . ' ' . esc_html( $this->options['target_label'] );
			$html .= '</label>';
			$html .= '</div>';
		}

		$html .= '</div>';

		return $html;
	}

}
