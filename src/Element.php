<?php
/**
 * Element Class
 *
 * Low-level HTML element generation with proper attribute handling and escaping.
 * This is the foundation class used internally by all field types.
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
 * Class Element
 *
 * Generates HTML elements with proper escaping and attribute handling.
 */
class Element {

	/**
	 * Self-closing HTML tags
	 *
	 * @var array
	 */
	protected static array $self_closing = [
		'input',
		'br',
		'hr',
		'img',
		'meta',
		'link',
		'area',
		'base',
		'col',
		'embed',
		'param',
		'source',
		'track',
		'wbr',
	];

	/**
	 * Boolean attributes (rendered without value when true)
	 *
	 * @var array
	 */
	protected static array $boolean_attrs = [
		'checked',
		'disabled',
		'readonly',
		'required',
		'multiple',
		'autofocus',
		'autoplay',
		'controls',
		'loop',
		'muted',
		'selected',
		'hidden',
		'open',
		'novalidate',
	];

	/**
	 * The HTML tag name
	 *
	 * @var string
	 */
	protected string $tag;

	/**
	 * Element attributes
	 *
	 * @var array
	 */
	protected array $attributes = [];

	/**
	 * Element content (for non-self-closing tags)
	 *
	 * @var string|null
	 */
	protected ?string $content = null;

	/**
	 * Create a new Element instance
	 *
	 * @param string      $tag        The HTML tag name.
	 * @param array       $attributes Element attributes.
	 * @param string|null $content    Element content.
	 */
	public function __construct( string $tag, array $attributes = [], ?string $content = null ) {
		$this->tag        = strtolower( $tag );
		$this->attributes = $this->normalize_attributes( $attributes );
		$this->content    = $content;
	}

	/**
	 * Static factory method
	 *
	 * @param string      $tag        The HTML tag name.
	 * @param array       $attributes Element attributes.
	 * @param string|null $content    Element content.
	 *
	 * @return self
	 */
	public static function create( string $tag, array $attributes = [], ?string $content = null ): self {
		return new self( $tag, $attributes, $content );
	}

	/**
	 * Set an attribute
	 *
	 * @param string $name  Attribute name.
	 * @param mixed  $value Attribute value.
	 *
	 * @return self
	 */
	public function set( string $name, $value ): self {
		$this->attributes[ $name ] = $value;

		return $this;
	}

	/**
	 * Add a class to the element
	 *
	 * @param string $class Class name(s) to add.
	 *
	 * @return self
	 */
	public function addClass( string $class ): self {
		$existing = $this->attributes['class'] ?? '';
		$classes  = array_filter( array_unique( array_merge(
			explode( ' ', $existing ),
			explode( ' ', $class )
		) ) );

		$this->attributes['class'] = implode( ' ', $classes );

		return $this;
	}

	/**
	 * Add data attributes
	 *
	 * @param array $data Array of data attributes (without 'data-' prefix).
	 *
	 * @return self
	 */
	public function data( array $data ): self {
		foreach ( $data as $key => $value ) {
			$this->attributes[ 'data-' . $key ] = $value;
		}

		return $this;
	}

	/**
	 * Set the element content
	 *
	 * @param string $content Element content.
	 *
	 * @return self
	 */
	public function content( string $content ): self {
		$this->content = $content;

		return $this;
	}

	/**
	 * Render the element as HTML
	 *
	 * @return string
	 */
	public function render(): string {
		$html = '<' . $this->tag . $this->render_attributes();

		if ( $this->is_self_closing() ) {
			$html .= ' />';
		} else {
			$html .= '>';
			if ( $this->content !== null ) {
				$html .= $this->content;
			}
			$html .= '</' . $this->tag . '>';
		}

		return $html;
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
	 * Normalize attributes array
	 *
	 * Handles special cases like 'data' array and 'attrs' passthrough.
	 *
	 * @param array $attributes Raw attributes array.
	 *
	 * @return array Normalized attributes.
	 */
	protected function normalize_attributes( array $attributes ): array {
		$normalized = [];

		foreach ( $attributes as $key => $value ) {
			// Handle data attributes array
			if ( $key === 'data' && is_array( $value ) ) {
				foreach ( $value as $data_key => $data_value ) {
					$normalized[ 'data-' . $data_key ] = $data_value;
				}
				continue;
			}

			// Handle attrs passthrough
			if ( $key === 'attrs' && is_array( $value ) ) {
				foreach ( $value as $attr_key => $attr_value ) {
					$normalized[ $attr_key ] = $attr_value;
				}
				continue;
			}

			// Skip null values
			if ( $value === null ) {
				continue;
			}

			$normalized[ $key ] = $value;
		}

		return $normalized;
	}

	/**
	 * Render attributes as HTML string
	 *
	 * @return string
	 */
	protected function render_attributes(): string {
		$html = '';

		foreach ( $this->attributes as $name => $value ) {
			// Skip empty values (except for value="0" which is valid)
			if ( $value === '' || $value === null ) {
				continue;
			}

			// Handle boolean attributes
			if ( in_array( $name, self::$boolean_attrs, true ) ) {
				if ( $value === true || $value === 'true' || $value === $name || $value === 1 || $value === '1' ) {
					$html .= ' ' . esc_attr( $name );
				}
				continue;
			}

			// Handle false boolean values - skip them
			if ( $value === false ) {
				continue;
			}

			// Standard attribute
			$html .= ' ' . esc_attr( $name ) . '="' . esc_attr( (string) $value ) . '"';
		}

		return $html;
	}

	/**
	 * Check if this is a self-closing tag
	 *
	 * @return bool
	 */
	protected function is_self_closing(): bool {
		return in_array( $this->tag, self::$self_closing, true );
	}

}
