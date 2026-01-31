# WordPress Elements

Pure HTML form field generation for WordPress admin interfaces. No JavaScript, no CSS dependencies—just clean, properly escaped markup.

## Installation

```bash
composer require arraypress/wp-elements
```

## Basic Usage

```php
use ArrayPress\Elements\Fields;

// Simple text field with label and description
echo Fields::text( 'username', $value, [
    'label'       => 'Username',
    'placeholder' => 'Enter username',
    'description' => 'Letters and numbers only',
    'required'    => true
] );

// Select dropdown
echo Fields::select( 'country', $value, [
    'label'   => 'Country',
    'options' => [
        'us' => 'United States',
        'uk' => 'United Kingdom',
        'ca' => 'Canada',
    ],
    'placeholder' => '— Select Country —'
] );

// Just the input element (no wrapper, label, or description)
echo Fields::text( 'email', $value )->input();
```

## Field Types

### Text Inputs

```php
// Standard text
Fields::text( 'name', $value, [ 'label' => 'Name' ] );

// URL with validation
Fields::url( 'website', $value, [ 'label' => 'Website' ] );

// Email with validation
Fields::email( 'email', $value, [ 'label' => 'Email Address' ] );

// Telephone
Fields::tel( 'phone', $value, [ 'label' => 'Phone Number' ] );

// Password
Fields::password( 'secret', $value, [ 'label' => 'Password' ] );

// Hidden field
Fields::hidden( 'user_id', $value );
```

### Textarea

```php
Fields::textarea( 'bio', $value, [
    'label' => 'Biography',
    'rows'  => 8,
    'placeholder' => 'Tell us about yourself...'
] );
```

### Number & Range

```php
// Number input
Fields::number( 'quantity', $value, [
    'label' => 'Quantity',
    'min'   => 1,
    'max'   => 100,
    'step'  => 1
] );

// Range slider with output display
Fields::range( 'volume', $value, [
    'label' => 'Volume',
    'min'   => 0,
    'max'   => 100,
    'step'  => 5,
    'unit'  => '%'
] );
```

### Select Dropdown

```php
// Simple select
Fields::select( 'size', $value, [
    'label'   => 'Size',
    'options' => [
        'sm' => 'Small',
        'md' => 'Medium',
        'lg' => 'Large',
    ]
] );

// Multiple select
Fields::select( 'colors', $value, [
    'label'    => 'Colors',
    'multiple' => true,
    'options'  => [
        'red'   => 'Red',
        'green' => 'Green',
        'blue'  => 'Blue',
    ]
] );

// With optgroups
Fields::select( 'vehicle', $value, [
    'label'   => 'Vehicle',
    'options' => [
        'Cars' => [
            'sedan'  => 'Sedan',
            'suv'    => 'SUV',
        ],
        'Motorcycles' => [
            'sport'   => 'Sport',
            'cruiser' => 'Cruiser',
        ],
    ]
] );

// With placeholder
Fields::select( 'status', $value, [
    'label'       => 'Status',
    'placeholder' => '— Select Status —',
    'options'     => [
        'draft'     => 'Draft',
        'published' => 'Published',
    ]
] );
```

### Checkboxes

```php
// Single checkbox (boolean)
Fields::checkbox( 'agree', $value, [
    'label' => 'I agree to the terms and conditions'
] );

// Checkbox group (multiple selection)
Fields::checkbox_group( 'features', $value, [
    'label'   => 'Features',
    'options' => [
        'wifi'    => 'WiFi',
        'parking' => 'Parking',
        'pool'    => 'Pool',
    ],
    'layout' => 'vertical' // or 'horizontal'
] );
```

### Radio Buttons

```php
Fields::radio( 'payment', $value, [
    'label'   => 'Payment Method',
    'options' => [
        'credit' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank'   => 'Bank Transfer',
    ],
    'layout' => 'vertical' // or 'horizontal'
] );
```

### Button Group

```php
// Single selection (like styled radio buttons)
Fields::button_group( 'alignment', $value, [
    'label'   => 'Alignment',
    'options' => [
        'left'   => 'Left',
        'center' => 'Center',
        'right'  => 'Right',
    ]
] );

// Multiple selection (like styled checkboxes)
Fields::button_group( 'days', $value, [
    'label'    => 'Days',
    'multiple' => true,
    'options'  => [
        'mon' => 'M',
        'tue' => 'T',
        'wed' => 'W',
        'thu' => 'T',
        'fri' => 'F',
    ]
] );
```

### Toggle Switch

```php
Fields::toggle( 'notifications', $value, [
    'label'     => 'Enable Notifications',
    'on_label'  => 'On',
    'off_label' => 'Off'
] );
```

### Color Picker

```php
Fields::color( 'brand_color', $value, [
    'label'   => 'Brand Color',
    'default' => '#3498db'
] );
```

### Date & Time

```php
// Date picker
Fields::date( 'start_date', $value, [
    'label' => 'Start Date',
    'min'   => '2024-01-01',
    'max'   => '2024-12-31'
] );

// Time picker
Fields::time( 'start_time', $value, [
    'label' => 'Start Time',
    'step'  => 900 // 15 minute intervals
] );

// DateTime picker
Fields::datetime( 'event_start', $value, [
    'label' => 'Event Start'
] );

// Date range (start & end)
Fields::date_range( 'event_dates', $value, [
    'label'       => 'Event Dates',
    'start_label' => 'From',
    'end_label'   => 'To'
] );
// Value: ['start' => '2024-06-01', 'end' => '2024-06-07']

// Time range (start & end)
Fields::time_range( 'business_hours', $value, [
    'label'       => 'Business Hours',
    'start_label' => 'Open',
    'end_label'   => 'Close'
] );
// Value: ['start' => '09:00', 'end' => '17:00']
```

### Buttons

```php
// Standard button
Fields::button( 'Click Me', [
    'id'   => 'my-button',
    'data' => [ 'action' => 'do-something' ]
] );

// Submit button (automatically styled as primary)
Fields::submit( 'Save Changes' );

// Reset button
Fields::reset( 'Clear Form' );

// Primary styled button
Fields::button( 'Important Action', [
    'primary' => true
] );

// Small button
Fields::button( 'Small', [ 'small' => true ] );

// Large button
Fields::button( 'Large', [ 'large' => true ] );
```

### Compound Fields

#### Dimensions (Width × Height)

```php
Fields::dimensions( 'banner_size', $value, [
    'label'        => 'Banner Size',
    'width_label'  => 'Width',
    'height_label' => 'Height',
    'unit'         => 'px',
    'min'          => 0,
    'max'          => 2000
] );
// Value: ['width' => 728, 'height' => 90]
```

#### Amount with Type

```php
Fields::amount_type( 'discount', $value, [
    'label'        => 'Discount',
    'type_options' => [
        'percent' => '%',
        'flat'    => '$',
    ],
    'type_default' => 'percent',
    'min'          => 0,
    'max'          => 100
] );
// Value: ['amount' => 15, 'type' => 'percent']
```

#### Link (URL + Title + Target)

```php
Fields::link( 'cta_link', $value, [
    'label'       => 'Call to Action',
    'show_title'  => true,
    'show_target' => true
] );
// Value: ['url' => 'https://...', 'title' => 'Learn More', 'target' => '_blank']
```

#### Price (Amount + Currency)

```php
Fields::price( 'product_price', $value, [
    'label'      => 'Price',
    'currencies' => [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
    ],
    'default_currency'  => 'USD',
    'currency_position' => 'before' // or 'after'
] );
// Value: ['amount' => 29.99, 'currency' => 'USD']
```

#### Number with Unit

```php
Fields::number_unit( 'margin', $value, [
    'label' => 'Margin',
    'units' => [
        'px'  => 'px',
        '%'   => '%',
        'em'  => 'em',
        'rem' => 'rem',
    ],
    'default_unit' => 'px'
] );
// Value: ['value' => 20, 'unit' => 'px']
```

## Common Options

All fields support these options:

| Option | Type | Default | Description |
|--------|------|---------|-------------|
| `id` | string | auto | HTML id attribute (defaults to name) |
| `label` | string | null | Field label text |
| `description` | string | null | Help text below field |
| `class` | string | '' | Additional CSS classes |
| `wrapper` | bool | true | Wrap in div with label/description |
| `required` | bool | false | Mark as required |
| `disabled` | bool | false | Disable the field |
| `readonly` | bool | false | Make read-only |
| `placeholder` | string | null | Placeholder text |
| `data` | array | [] | Data attributes |
| `attrs` | array | [] | Custom HTML attributes |

## Data Attributes

Add data attributes for JavaScript hooks:

```php
Fields::select( 'post_id', $value, [
    'label'   => 'Select Post',
    'options' => $posts,
    'data'    => [
        'field-type' => 'ajax-search',
        'endpoint'   => '/wp-json/my/v1/posts',
        'min-chars'  => 3
    ]
] );
// Outputs: data-field-type="ajax-search" data-endpoint="..." data-min-chars="3"
```

## Custom Attributes

Add any HTML attributes:

```php
Fields::text( 'code', $value, [
    'label' => 'Verification Code',
    'attrs' => [
        'autocomplete' => 'off',
        'spellcheck'   => 'false',
        'maxlength'    => 6
    ]
] );
```

## Rendering Without Wrapper

Get just the input element:

```php
// Method 1: Chain ->input()
echo Fields::text( 'email', $value )->input();

// Method 2: Set wrapper option to false
echo Fields::text( 'email', $value, [ 'wrapper' => false ] );
```

## Using the Element Class Directly

For custom HTML generation:

```php
use ArrayPress\Elements\Element;

// Create any HTML element
$div = Element::create( 'div', [
    'class' => 'my-class',
    'id'    => 'my-id',
    'data'  => [
        'value' => 123
    ]
], 'Content here' );

echo $div; // <div class="my-class" id="my-id" data-value="123">Content here</div>

// Self-closing elements
$input = Element::create( 'input', [
    'type'  => 'text',
    'name'  => 'field',
    'value' => 'test'
] );

echo $input; // <input type="text" name="field" value="test" />
```

## Registering Custom Field Types

```php
use ArrayPress\Elements\Fields;
use ArrayPress\Elements\Field;

// Create your custom field class
class MyCustomField extends Field {
    protected function get_type_defaults(): array {
        return [
            'custom_option' => 'default'
        ];
    }
    
    public function render_input(): string {
        // Your custom rendering logic
        return '<div class="my-custom-field">...</div>';
    }
}

// Register it
Fields::register( 'my_custom', MyCustomField::class );

// Use it
echo Fields::my_custom( 'field_name', $value, [ 'label' => 'My Field' ] );
```

## Requirements

- PHP 7.4 or higher
- WordPress (for escaping functions: `esc_attr`, `esc_html`, `esc_textarea`)

## Optional Assets

The library includes minimal CSS and JS for fields that need styling to function (toggles, button groups, etc.). Enqueue them if you want base functionality out of the box:

```php
add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( $hook !== 'settings_page_my-plugin' ) {
        return;
    }
    
    wp_elements_enqueue();
} );
```

**CSS provides:** Toggle switch styling, button group layout, range slider output, compound field layouts.

**JavaScript provides:** Button group selection state, range slider live output updates.

## Global Helper

Render a field without importing the Fields class:

```php
echo wp_render_field( 'text', 'username', $value, [
    'label' => 'Username',
    'required' => true,
] );

echo wp_render_field( 'select', 'country', $value, [
    'options' => [ 'us' => 'USA', 'uk' => 'UK' ],
    'default' => 'us',
] );
```

## License

GPL-2.0-or-later