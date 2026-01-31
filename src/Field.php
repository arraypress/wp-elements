<?php
/**
 * Base Field Class
 *
 * Abstract base class for all form field types. Provides common
 * functionality for labels, descriptions, wrappers, and attributes.
 *
 * @package     ArrayPress\Elements
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\Elements;

/**
 * Class Field
 *
 * Base class for form fields with label, description, and wrapper support.
 */
abstract class Field {

	/**
	 * Field name attribute
	 *
	 * @var string
	 */
	protected string $name;

	/**
	 * Field value
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Field options/configuration
	 *
	 * @var array
	 */
	protected array $options = [];

	/**
	 * Default options for this field type
	 *
	 * @var array
	 */
	protected array $defaults = [
		'id'          => null,
		'label'       => null,
		'description' => null,
		'class'       => '',
		'wrapper'     => true,
		'required'    => false,
		'disabled'    => false,
		'readonly'    => false,
		'placeholder' => null,
		'data'        => [],
		'attrs'       => [],
	];

	/**
	 * Create a new field instance
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 */
	public function __construct( string $name, $value = null, array $options = [] ) {
		$this->name    = $name;
		$this->value   = $value;
		$this->options = array_merge( $this->defaults, $this->get_type_defaults(), $options );

		// Use name as ID if not specified
		if ( $this->options['id'] === null ) {
			$this->options['id'] = $this->sanitize_id( $name );
		}
	}

	/**
	 * Get type-specific default options
	 *
	 * Override in child classes to add field-specific defaults.
	 *
	 * @return array
	 */
	protected function get_type_defaults(): array {
		return [];
	}

	/**
	 * Render the complete field with wrapper, label, and description
	 *
	 * @return string
	 */
	public function render(): string {
		if ( ! $this->options['wrapper'] ) {
			return $this->render_input();
		}

		$html = '<div class="' . esc_attr( $this->get_wrapper_class() ) . '">';

		// Label
		if ( ! empty( $this->options['label'] ) ) {
			$html .= $this->render_label();
		}

		// Input
		$html .= $this->render_input();

		// Description
		if ( ! empty( $this->options['description'] ) ) {
			$html .= $this->render_description();
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Render just the input element(s)
	 *
	 * Must be implemented by child classes.
	 *
	 * @return string
	 */
	abstract public function render_input(): string;

	/**
	 * Render the field label
	 *
	 * @return string
	 */
	protected function render_label(): string {
		$required = $this->options['required'] ? ' <span class="required">*</span>' : '';

		return sprintf(
			'<label for="%s">%s%s</label>',
			esc_attr( $this->options['id'] ),
			esc_html( $this->options['label'] ),
			$required
		);
	}

	/**
	 * Render the field description
	 *
	 * @return string
	 */
	protected function render_description(): string {
		return sprintf(
			'<p class="description">%s</p>',
			esc_html( $this->options['description'] )
		);
	}

	/**
	 * Get the wrapper CSS class
	 *
	 * @return string
	 */
	protected function get_wrapper_class(): string {
		$classes = [ 'form-field', 'field-' . $this->get_type() ];

		if ( $this->options['required'] ) {
			$classes[] = 'field-required';
		}

		return implode( ' ', $classes );
	}

	/**
	 * Get the field type identifier
	 *
	 * @return string
	 */
	protected function get_type(): string {
		$class = get_class( $this );
		$parts = explode( '\\', $class );

		return strtolower( end( $parts ) );
	}

	/**
	 * Build common input attributes
	 *
	 * @param array $extra Additional attributes to merge.
	 *
	 * @return array
	 */
	protected function build_attributes( array $extra = [] ): array {
		$attrs = [
			'id'   => $this->options['id'],
			'name' => $this->name,
		];

		// Add standard attributes if set
		foreach ( [ 'required', 'disabled', 'readonly' ] as $attr ) {
			if ( ! empty( $this->options[ $attr ] ) ) {
				$attrs[ $attr ] = true;
			}
		}

		// Add placeholder if set
		if ( ! empty( $this->options['placeholder'] ) ) {
			$attrs['placeholder'] = $this->options['placeholder'];
		}

		// Add class if set
		if ( ! empty( $this->options['class'] ) ) {
			$attrs['class'] = $this->options['class'];
		}

		// Add data attributes
		if ( ! empty( $this->options['data'] ) ) {
			$attrs['data'] = $this->options['data'];
		}

		// Add custom attributes
		if ( ! empty( $this->options['attrs'] ) ) {
			$attrs['attrs'] = $this->options['attrs'];
		}

		return array_merge( $attrs, $extra );
	}

	/**
	 * Sanitize a string for use as an HTML ID
	 *
	 * @param string $string String to sanitize.
	 *
	 * @return string
	 */
	protected function sanitize_id( string $string ): string {
		// Replace brackets and special chars with underscores
		$id = preg_replace( '/[^a-zA-Z0-9_-]/', '_', $string );

		// Remove consecutive underscores
		$id = preg_replace( '/_+/', '_', $id );

		// Trim underscores from ends
		return trim( $id, '_' );
	}

	/**
	 * Convert to string
	 *
	 * @return string
	 */
	public function __toString(): string {
		return $this->render();
	}

	/**
	 * Render just the input (alias for render_input)
	 *
	 * @return string
	 */
	public function input(): string {
		return $this->render_input();
	}

}
