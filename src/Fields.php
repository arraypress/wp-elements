<?php
/**
 * Fields Factory Class
 *
 * Static factory for creating form fields. This is the primary
 * public API for the library.
 *
 * @package     ArrayPress\Elements
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL2+
 * @version     1.0.0
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\Elements;

use ArrayPress\Elements\Fields\Text;
use ArrayPress\Elements\Fields\Textarea;
use ArrayPress\Elements\Fields\Number;
use ArrayPress\Elements\Fields\Range;
use ArrayPress\Elements\Fields\Select;
use ArrayPress\Elements\Fields\Checkbox;
use ArrayPress\Elements\Fields\CheckboxGroup;
use ArrayPress\Elements\Fields\Radio;
use ArrayPress\Elements\Fields\ButtonGroup;
use ArrayPress\Elements\Fields\Toggle;
use ArrayPress\Elements\Fields\Color;
use ArrayPress\Elements\Fields\Date;
use ArrayPress\Elements\Fields\Time;
use ArrayPress\Elements\Fields\DateTime;
use ArrayPress\Elements\Fields\DateRange;
use ArrayPress\Elements\Fields\TimeRange;
use ArrayPress\Elements\Fields\Hidden;
use ArrayPress\Elements\Fields\Button;
use ArrayPress\Elements\Fields\Dimensions;
use ArrayPress\Elements\Fields\AmountType;
use ArrayPress\Elements\Fields\Link;
use ArrayPress\Elements\Fields\Price;
use ArrayPress\Elements\Fields\NumberUnit;

/**
 * Class Fields
 *
 * Static factory for creating form fields.
 */
class Fields {

	/**
	 * Custom field type to class mapping
	 *
	 * @var array
	 */
	protected static array $custom_types = [];

	/* =========================================================================
	   Text Input Fields
	   ========================================================================= */

	/**
	 * Create a text input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Text
	 */
	public static function text( string $name, $value = null, array $options = [] ): Text {
		$options['type'] = 'text';

		return new Text( $name, $value, $options );
	}

	/**
	 * Create a URL input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Text
	 */
	public static function url( string $name, $value = null, array $options = [] ): Text {
		$options['type'] = 'url';

		return new Text( $name, $value, $options );
	}

	/**
	 * Create an email input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Text
	 */
	public static function email( string $name, $value = null, array $options = [] ): Text {
		$options['type'] = 'email';

		return new Text( $name, $value, $options );
	}

	/**
	 * Create a telephone input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Text
	 */
	public static function tel( string $name, $value = null, array $options = [] ): Text {
		$options['type'] = 'tel';

		return new Text( $name, $value, $options );
	}

	/**
	 * Create a password input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Text
	 */
	public static function password( string $name, $value = null, array $options = [] ): Text {
		$options['type'] = 'password';

		return new Text( $name, $value, $options );
	}

	/**
	 * Create a hidden input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Hidden
	 */
	public static function hidden( string $name, $value = null, array $options = [] ): Hidden {
		return new Hidden( $name, $value, $options );
	}

	/**
	 * Create a textarea field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options (rows, cols, etc.).
	 *
	 * @return Textarea
	 */
	public static function textarea( string $name, $value = null, array $options = [] ): Textarea {
		return new Textarea( $name, $value, $options );
	}

	/* =========================================================================
	   Numeric Fields
	   ========================================================================= */

	/**
	 * Create a number input field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options (min, max, step).
	 *
	 * @return Number
	 */
	public static function number( string $name, $value = null, array $options = [] ): Number {
		return new Number( $name, $value, $options );
	}

	/**
	 * Create a range slider field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options (min, max, step, unit, show_output).
	 *
	 * @return Range
	 */
	public static function range( string $name, $value = null, array $options = [] ): Range {
		return new Range( $name, $value, $options );
	}

	/* =========================================================================
	   Choice Fields
	   ========================================================================= */

	/**
	 * Create a select dropdown field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (string or array for multiple).
	 * @param array  $options Field options (options, multiple, placeholder, default).
	 *
	 * @return Select
	 */
	public static function select( string $name, $value = null, array $options = [] ): Select {
		return new Select( $name, $value, $options );
	}

	/**
	 * Create a single checkbox field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (checked state).
	 * @param array  $options Field options.
	 *
	 * @return Checkbox
	 */
	public static function checkbox( string $name, $value = null, array $options = [] ): Checkbox {
		return new Checkbox( $name, $value, $options );
	}

	/**
	 * Create a checkbox group field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (array of selected values).
	 * @param array  $options Field options (options, layout).
	 *
	 * @return CheckboxGroup
	 */
	public static function checkbox_group( string $name, $value = null, array $options = [] ): CheckboxGroup {
		return new CheckboxGroup( $name, $value, $options );
	}

	/**
	 * Create a radio button group field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (selected value).
	 * @param array  $options Field options (options, layout).
	 *
	 * @return Radio
	 */
	public static function radio( string $name, $value = null, array $options = [] ): Radio {
		return new Radio( $name, $value, $options );
	}

	/**
	 * Create a button group field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (string or array for multiple).
	 * @param array  $options Field options (options, multiple).
	 *
	 * @return ButtonGroup
	 */
	public static function button_group( string $name, $value = null, array $options = [] ): ButtonGroup {
		return new ButtonGroup( $name, $value, $options );
	}

	/**
	 * Create a toggle switch field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (checked state).
	 * @param array  $options Field options (on_label, off_label).
	 *
	 * @return Toggle
	 */
	public static function toggle( string $name, $value = null, array $options = [] ): Toggle {
		return new Toggle( $name, $value, $options );
	}

	/* =========================================================================
	   Color Field
	   ========================================================================= */

	/**
	 * Create a color picker field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (hex color).
	 * @param array  $options Field options (default).
	 *
	 * @return Color
	 */
	public static function color( string $name, $value = null, array $options = [] ): Color {
		return new Color( $name, $value, $options );
	}

	/* =========================================================================
	   Date & Time Fields
	   ========================================================================= */

	/**
	 * Create a date picker field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (Y-m-d format).
	 * @param array  $options Field options (min, max).
	 *
	 * @return Date
	 */
	public static function date( string $name, $value = null, array $options = [] ): Date {
		return new Date( $name, $value, $options );
	}

	/**
	 * Create a time picker field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (H:i format).
	 * @param array  $options Field options (min, max, step).
	 *
	 * @return Time
	 */
	public static function time( string $name, $value = null, array $options = [] ): Time {
		return new Time( $name, $value, $options );
	}

	/**
	 * Create a datetime picker field
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (Y-m-d\TH:i format).
	 * @param array  $options Field options (min, max).
	 *
	 * @return DateTime
	 */
	public static function datetime( string $name, $value = null, array $options = [] ): DateTime {
		return new DateTime( $name, $value, $options );
	}

	/**
	 * Create a date range field (start + end dates)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['start' => '', 'end' => '']).
	 * @param array  $options Field options (start_label, end_label, min, max).
	 *
	 * @return DateRange
	 */
	public static function date_range( string $name, $value = null, array $options = [] ): DateRange {
		return new DateRange( $name, $value, $options );
	}

	/**
	 * Create a time range field (start + end times)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['start' => '', 'end' => '']).
	 * @param array  $options Field options (start_label, end_label, step).
	 *
	 * @return TimeRange
	 */
	public static function time_range( string $name, $value = null, array $options = [] ): TimeRange {
		return new TimeRange( $name, $value, $options );
	}

	/* =========================================================================
	   Button Fields
	   ========================================================================= */

	/**
	 * Create a button element
	 *
	 * @param string $text    Button text.
	 * @param array  $options Button options (type, primary, small, large).
	 *
	 * @return Button
	 */
	public static function button( string $text, array $options = [] ): Button {
		$options['type'] = $options['type'] ?? 'button';

		return new Button( $text, $options );
	}

	/**
	 * Create a submit button
	 *
	 * @param string $text    Button text.
	 * @param array  $options Button options.
	 *
	 * @return Button
	 */
	public static function submit( string $text = 'Submit', array $options = [] ): Button {
		$options['type'] = 'submit';

		return new Button( $text, $options );
	}

	/**
	 * Create a reset button
	 *
	 * @param string $text    Button text.
	 * @param array  $options Button options.
	 *
	 * @return Button
	 */
	public static function reset( string $text = 'Reset', array $options = [] ): Button {
		$options['type'] = 'reset';

		return new Button( $text, $options );
	}

	/* =========================================================================
	   Compound Fields
	   ========================================================================= */

	/**
	 * Create a dimensions field (width × height)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['width' => '', 'height' => '']).
	 * @param array  $options Field options (width_label, height_label, unit, min, max).
	 *
	 * @return Dimensions
	 */
	public static function dimensions( string $name, $value = null, array $options = [] ): Dimensions {
		return new Dimensions( $name, $value, $options );
	}

	/**
	 * Create an amount + type field (e.g., discount with percent/flat)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['amount' => '', 'type' => '']).
	 * @param array  $options Field options (type_options, type_default, min, max, step).
	 *
	 * @return AmountType
	 */
	public static function amount_type( string $name, $value = null, array $options = [] ): AmountType {
		return new AmountType( $name, $value, $options );
	}

	/**
	 * Create a link field (URL + title + target)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['url' => '', 'title' => '', 'target' => '']).
	 * @param array  $options Field options (show_title, show_target, url_label, title_label).
	 *
	 * @return Link
	 */
	public static function link( string $name, $value = null, array $options = [] ): Link {
		return new Link( $name, $value, $options );
	}

	/**
	 * Create a price field (amount + currency)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['amount' => '', 'currency' => '']).
	 * @param array  $options Field options (currencies, default_currency, currency_position, min, max, step).
	 *
	 * @return Price
	 */
	public static function price( string $name, $value = null, array $options = [] ): Price {
		return new Price( $name, $value, $options );
	}

	/**
	 * Create a number + unit field (e.g., 10px, 50%, 2rem)
	 *
	 * @param string $name    Field name attribute.
	 * @param mixed  $value   Field value (['value' => '', 'unit' => '']).
	 * @param array  $options Field options (units, default_unit, min, max, step).
	 *
	 * @return NumberUnit
	 */
	public static function number_unit( string $name, $value = null, array $options = [] ): NumberUnit {
		return new NumberUnit( $name, $value, $options );
	}

	/* =========================================================================
	   Dynamic Field Creation
	   ========================================================================= */

	/**
	 * Create a field by type name
	 *
	 * Useful when the field type is determined dynamically.
	 *
	 * @param string $type    Field type.
	 * @param string $name    Field name.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Field|null
	 */
	public static function create( string $type, string $name, $value = null, array $options = [] ): ?Field {
		// Check for explicit methods first
		if ( method_exists( self::class, $type ) ) {
			return self::$type( $name, $value, $options );
		}

		// Check custom registered types
		if ( isset( self::$custom_types[ $type ] ) ) {
			$class = self::$custom_types[ $type ];

			return new $class( $name, $value, $options );
		}

		return null;
	}

	/**
	 * Register a custom field type
	 *
	 * @param string $type  Field type name.
	 * @param string $class Fully qualified class name (must extend Field).
	 *
	 * @return void
	 */
	public static function register( string $type, string $class ): void {
		self::$custom_types[ $type ] = $class;
	}

	/**
	 * Check if a field type is available
	 *
	 * @param string $type Field type name.
	 *
	 * @return bool
	 */
	public static function has( string $type ): bool {
		return method_exists( self::class, $type ) || isset( self::$custom_types[ $type ] );
	}

	/**
	 * Get all available field types
	 *
	 * @return array
	 */
	public static function types(): array {
		$builtin = [
			'text',
			'url',
			'email',
			'tel',
			'password',
			'hidden',
			'textarea',
			'number',
			'range',
			'select',
			'checkbox',
			'checkbox_group',
			'radio',
			'button_group',
			'toggle',
			'color',
			'date',
			'time',
			'datetime',
			'date_range',
			'time_range',
			'button',
			'submit',
			'reset',
			'dimensions',
			'amount_type',
			'link',
			'price',
			'number_unit',
		];

		return array_merge( $builtin, array_keys( self::$custom_types ) );
	}

	/**
	 * Magic static method handler for custom registered types
	 *
	 * @param string $method    Method name (field type).
	 * @param array  $arguments Method arguments.
	 *
	 * @return Field|null
	 */
	public static function __callStatic( string $method, array $arguments ): ?Field {
		// Only handle custom registered types
		if ( ! isset( self::$custom_types[ $method ] ) ) {
			return null;
		}

		$class   = self::$custom_types[ $method ];
		$name    = $arguments[0] ?? '';
		$value   = $arguments[1] ?? null;
		$options = $arguments[2] ?? [];

		return new $class( $name, $value, $options );
	}

}