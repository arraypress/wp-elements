<?php
/**
 * Button Field Class
 *
 * Button element for forms (button, submit, reset).
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
 * Class Button
 *
 * Button element.
 */
class Button extends Field {

	/**
	 * The button text
	 *
	 * @var string
	 */
	protected string $text;

	/**
	 * Create a new Button instance
	 *
	 * @param string $text    Button text.
	 * @param array  $options Button options.
	 */
	public function __construct( string $text, array $options = [] ) {
		$this->text = $text;

		// Extract name and value from options, defaulting appropriately
		$name  = $options['name'] ?? '';
		$value = $options['value'] ?? null;

		// Call parent constructor
		parent::__construct( $name, $value, $options );

		// Override ID generation to use text if not specified
		if ( empty( $options['id'] ) ) {
			$this->options['id'] = $this->sanitize_id( $text );
		}
	}

	/**
	 * Get type-specific default options
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [
			'type'    => 'button',
			'wrapper' => false,
			'primary' => false,
			'small'   => false,
			'large'   => false,
		];
	}

	/**
	 * Render the complete field
	 *
	 * Buttons don't use wrappers by default.
	 *
	 * @return string
	 */
	public function render(): string {
		return $this->render_input();
	}

	/**
	 * Render the button element
	 *
	 * @return string
	 */
	public function render_input(): string {
		// Build class
		$classes = [ 'button' ];

		if ( $this->options['primary'] || $this->options['type'] === 'submit' ) {
			$classes[] = 'button-primary';
		}

		if ( $this->options['small'] ) {
			$classes[] = 'button-small';
		}

		if ( $this->options['large'] ) {
			$classes[] = 'button-large';
		}

		if ( ! empty( $this->options['class'] ) ) {
			$classes[] = $this->options['class'];
		}

		$attrs = [
			'type'  => $this->options['type'],
			'id'    => $this->options['id'],
			'class' => implode( ' ', $classes ),
		];

		// Add name if set
		if ( ! empty( $this->name ) ) {
			$attrs['name'] = $this->name;
		}

		// Add value if set
		if ( $this->value !== null ) {
			$attrs['value'] = $this->value;
		}

		// Add disabled
		if ( $this->options['disabled'] ) {
			$attrs['disabled'] = true;
		}

		// Add data attributes
		if ( ! empty( $this->options['data'] ) ) {
			$attrs['data'] = $this->options['data'];
		}

		// Add custom attributes
		if ( ! empty( $this->options['attrs'] ) ) {
			$attrs['attrs'] = $this->options['attrs'];
		}

		return Element::create( 'button', $attrs, esc_html( $this->text ) )->render();
	}

}
