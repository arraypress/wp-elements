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
 *
 * @method static Text text( string $name, $value = null, array $options = [] )
 * @method static Text url( string $name, $value = null, array $options = [] )
 * @method static Text email( string $name, $value = null, array $options = [] )
 * @method static Text tel( string $name, $value = null, array $options = [] )
 * @method static Text password( string $name, $value = null, array $options = [] )
 * @method static Hidden hidden( string $name, $value = null, array $options = [] )
 * @method static Textarea textarea( string $name, $value = null, array $options = [] )
 * @method static Number number( string $name, $value = null, array $options = [] )
 * @method static Range range( string $name, $value = null, array $options = [] )
 * @method static Select select( string $name, $value = null, array $options = [] )
 * @method static Checkbox checkbox( string $name, $value = null, array $options = [] )
 * @method static CheckboxGroup checkbox_group( string $name, $value = null, array $options = [] )
 * @method static Radio radio( string $name, $value = null, array $options = [] )
 * @method static ButtonGroup button_group( string $name, $value = null, array $options = [] )
 * @method static Toggle toggle( string $name, $value = null, array $options = [] )
 * @method static Color color( string $name, $value = null, array $options = [] )
 * @method static Date date( string $name, $value = null, array $options = [] )
 * @method static Time time( string $name, $value = null, array $options = [] )
 * @method static DateTime datetime( string $name, $value = null, array $options = [] )
 * @method static DateRange date_range( string $name, $value = null, array $options = [] )
 * @method static TimeRange time_range( string $name, $value = null, array $options = [] )
 * @method static Button button( string $text, array $options = [] )
 * @method static Button submit( string $text = 'Submit', array $options = [] )
 * @method static Button reset( string $text = 'Reset', array $options = [] )
 * @method static Dimensions dimensions( string $name, $value = null, array $options = [] )
 * @method static AmountType amount_type( string $name, $value = null, array $options = [] )
 * @method static Link link( string $name, $value = null, array $options = [] )
 * @method static Price price( string $name, $value = null, array $options = [] )
 * @method static NumberUnit number_unit( string $name, $value = null, array $options = [] )
 */
class Fields {

	/**
	 * Field type to class mapping
	 *
	 * @var array
	 */
	protected static array $types = [
		'text'           => Text::class,
		'url'            => Text::class,
		'email'          => Text::class,
		'tel'            => Text::class,
		'password'       => Text::class,
		'hidden'         => Hidden::class,
		'textarea'       => Textarea::class,
		'number'         => Number::class,
		'range'          => Range::class,
		'select'         => Select::class,
		'checkbox'       => Checkbox::class,
		'checkbox_group' => CheckboxGroup::class,
		'radio'          => Radio::class,
		'button_group'   => ButtonGroup::class,
		'toggle'         => Toggle::class,
		'color'          => Color::class,
		'date'           => Date::class,
		'time'           => Time::class,
		'datetime'       => DateTime::class,
		'date_range'     => DateRange::class,
		'time_range'     => TimeRange::class,
		'button'         => Button::class,
		'submit'         => Button::class,
		'reset'          => Button::class,
		'dimensions'     => Dimensions::class,
		'amount_type'    => AmountType::class,
		'link'           => Link::class,
		'price'          => Price::class,
		'number_unit'    => NumberUnit::class,
	];

	/**
	 * Text input types that use the Text class
	 *
	 * @var array
	 */
	protected static array $text_types = [ 'text', 'url', 'email', 'tel', 'password' ];

	/**
	 * Button types that use the Button class
	 *
	 * @var array
	 */
	protected static array $button_types = [ 'button', 'submit', 'reset' ];

	/**
	 * Magic static method handler
	 *
	 * @param string $method    Method name (field type).
	 * @param array  $arguments Method arguments.
	 *
	 * @return Field|null
	 */
	public static function __callStatic( string $method, array $arguments ) {
		// Check if it's a valid field type
		if ( ! isset( self::$types[ $method ] ) ) {
			return null;
		}

		$class = self::$types[ $method ];

		// Handle text input types
		if ( in_array( $method, self::$text_types, true ) ) {
			$name    = $arguments[0] ?? '';
			$value   = $arguments[1] ?? null;
			$options = $arguments[2] ?? [];

			$options['type'] = $method;

			return new $class( $name, $value, $options );
		}

		// Handle button types
		if ( in_array( $method, self::$button_types, true ) ) {
			$text    = $arguments[0] ?? ucfirst( $method );
			$options = $arguments[1] ?? [];

			$options['type'] = $method;

			return new $class( $text, $options );
		}

		// Standard field creation
		$name    = $arguments[0] ?? '';
		$value   = $arguments[1] ?? null;
		$options = $arguments[2] ?? [];

		return new $class( $name, $value, $options );
	}

	/**
	 * Create a field by type name
	 *
	 * @param string $type    Field type.
	 * @param string $name    Field name.
	 * @param mixed  $value   Field value.
	 * @param array  $options Field options.
	 *
	 * @return Field|null
	 */
	public static function create( string $type, string $name, $value = null, array $options = [] ): ?Field {
		return self::__callStatic( $type, [ $name, $value, $options ] );
	}

	/**
	 * Register a custom field type
	 *
	 * @param string $type  Field type name.
	 * @param string $class Fully qualified class name.
	 *
	 * @return void
	 */
	public static function register( string $type, string $class ): void {
		self::$types[ $type ] = $class;
	}

	/**
	 * Check if a field type is registered
	 *
	 * @param string $type Field type name.
	 *
	 * @return bool
	 */
	public static function has( string $type ): bool {
		return isset( self::$types[ $type ] );
	}

	/**
	 * Get all registered field types
	 *
	 * @return array
	 */
	public static function types(): array {
		return array_keys( self::$types );
	}

}
