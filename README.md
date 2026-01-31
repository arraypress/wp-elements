# WordPress Elements

Pure HTML form field generation for WordPress admin interfaces. No JavaScript dependencies, no CSS dependencies—just
clean, properly escaped markup.

## Installation

```bash
composer require arraypress/wp-elements
```

**Dependencies:** Requires `arraypress/wp-composer-assets` for asset loading helpers.

## Quick Start

```php
use ArrayPress\Elements\Fields;

// Text field with label and description
echo Fields::text( 'username', $value, [
    'label'       => 'Username',
    'placeholder' => 'Enter username',
    'description' => 'Letters and numbers only',
    'required'    => true,
] );

// Select dropdown
echo Fields::select( 'country', $value, [
    'label'       => 'Country',
    'placeholder' => '— Select Country —',
    'default'     => 'us',
    'options'     => [
        'us' => 'United States',
        'uk' => 'United Kingdom',
    ],
] );

// Just the input element (no wrapper/label/description)
echo Fields::text( 'email', $value )->input();
```

## Architecture

```
Element          - Low-level HTML element generation
    ↓
Field (abstract) - Base class with wrapper, label, description
    ↓
Text, Select...  - Specific field implementations
    ↓
Fields           - Static factory (public API)
```

---

## Field Types

### Text Inputs

All text-based inputs use the same `Text` class with different `type` options.

```php
Fields::text( 'name', $value, [ 'label' => 'Name' ] );
Fields::url( 'website', $value, [ 'label' => 'Website' ] );
Fields::email( 'email', $value, [ 'label' => 'Email' ] );
Fields::tel( 'phone', $value, [ 'label' => 'Phone' ] );
Fields::password( 'secret', $value, [ 'label' => 'Password' ] );
Fields::hidden( 'token', $value );
```

**Text-specific options:**

| Option      | Type   | Default | Description                                  |
|-------------|--------|---------|----------------------------------------------|
| `type`      | string | 'text'  | Input type (text, url, email, tel, password) |
| `maxlength` | int    | null    | Maximum character length                     |
| `minlength` | int    | null    | Minimum character length                     |
| `pattern`   | string | null    | Regex pattern for validation                 |
| `size`      | int    | null    | Visible width in characters                  |

### Textarea

```php
Fields::textarea( 'bio', $value, [
    'label'       => 'Biography',
    'rows'        => 8,
    'cols'        => 50,
    'placeholder' => 'Tell us about yourself...',
    'maxlength'   => 500,
] );
```

**Options:**

| Option      | Type | Default | Description              |
|-------------|------|---------|--------------------------|
| `rows`      | int  | 5       | Visible rows             |
| `cols`      | int  | null    | Visible columns          |
| `maxlength` | int  | null    | Maximum character length |
| `minlength` | int  | null    | Minimum character length |

### Number

```php
Fields::number( 'quantity', $value, [
    'label' => 'Quantity',
    'min'   => 1,
    'max'   => 100,
    'step'  => 1,
] );
```

**Options:**

| Option | Type   | Default | Description    |
|--------|--------|---------|----------------|
| `min`  | number | null    | Minimum value  |
| `max`  | number | null    | Maximum value  |
| `step` | number | null    | Step increment |

### Range

```php
Fields::range( 'volume', $value, [
    'label'       => 'Volume',
    'min'         => 0,
    'max'         => 100,
    'step'        => 5,
    'unit'        => '%',
    'show_output' => true,
] );
```

**Options:**

| Option        | Type   | Default | Description                    |
|---------------|--------|---------|--------------------------------|
| `min`         | number | 0       | Minimum value                  |
| `max`         | number | 100     | Maximum value                  |
| `step`        | number | 1       | Step increment                 |
| `unit`        | string | ''      | Unit displayed after value     |
| `show_output` | bool   | true    | Show live value output element |

**Note:** Requires CSS/JS for output display. Enqueue via `wp_elements_enqueue()`.

### Select

```php
// Simple
Fields::select( 'size', $value, [
    'label'   => 'Size',
    'options' => [
        'sm' => 'Small',
        'md' => 'Medium',
        'lg' => 'Large',
    ],
] );

// With placeholder and default
Fields::select( 'status', $value, [
    'label'       => 'Status',
    'placeholder' => '— Select —',
    'default'     => 'draft',
    'options'     => [
        'draft'     => 'Draft',
        'published' => 'Published',
    ],
] );

// Multiple selection
Fields::select( 'colors', $value, [
    'label'    => 'Colors',
    'multiple' => true,
    'size'     => 5,
    'options'  => [
        'red'   => 'Red',
        'green' => 'Green',
        'blue'  => 'Blue',
    ],
] );

// With optgroups
Fields::select( 'vehicle', $value, [
    'label'   => 'Vehicle',
    'options' => [
        'Cars' => [
            'sedan' => 'Sedan',
            'suv'   => 'SUV',
        ],
        'Bikes' => [
            'sport'   => 'Sport',
            'cruiser' => 'Cruiser',
        ],
    ],
] );

// Disabled options
Fields::select( 'plan', $value, [
    'options' => [
        'free' => 'Free',
        'pro'  => [ 'label' => 'Pro (Coming Soon)', 'disabled' => true ],
    ],
] );
```

**Options:**

| Option        | Type         | Default | Description                      |
|---------------|--------------|---------|----------------------------------|
| `options`     | array        | []      | Key-value pairs or optgroups     |
| `multiple`    | bool         | false   | Allow multiple selection         |
| `size`        | int          | null    | Visible rows for multiple        |
| `placeholder` | string       | null    | Placeholder option text          |
| `default`     | string/array | null    | Default value if $value is empty |

**Value format:** String for single, array for multiple.

### Checkbox

```php
Fields::checkbox( 'agree', $value, [
    'label'          => 'Terms & Conditions',
    'checkbox_label' => 'I agree to the terms',
    'checkbox_value' => 'yes',
] );
```

**Options:**

| Option           | Type   | Default | Description                                  |
|------------------|--------|---------|----------------------------------------------|
| `checkbox_value` | string | '1'     | Value when checked                           |
| `checkbox_label` | string | null    | Text next to checkbox (uses `label` if null) |

**Value:** Truthy = checked.

### Checkbox Group

```php
Fields::checkbox_group( 'features', $value, [
    'label'   => 'Features',
    'layout'  => 'vertical',
    'options' => [
        'wifi'    => 'WiFi',
        'parking' => 'Parking',
        'pool'    => [ 'label' => 'Pool', 'disabled' => true ],
    ],
] );
```

**Options:**

| Option    | Type   | Default    | Description                                                   |
|-----------|--------|------------|---------------------------------------------------------------|
| `options` | array  | []         | Key-value pairs (value can be array with `label`, `disabled`) |
| `layout`  | string | 'vertical' | Layout: 'vertical' or 'horizontal'                            |

**Value format:** Array of selected values, e.g., `['wifi', 'pool']`

### Radio

```php
Fields::radio( 'payment', $value, [
    'label'   => 'Payment Method',
    'layout'  => 'vertical',
    'options' => [
        'credit' => 'Credit Card',
        'paypal' => 'PayPal',
        'bank'   => [ 'label' => 'Bank Transfer', 'disabled' => true ],
    ],
] );
```

**Options:**

| Option    | Type   | Default    | Description                                                   |
|-----------|--------|------------|---------------------------------------------------------------|
| `options` | array  | []         | Key-value pairs (value can be array with `label`, `disabled`) |
| `layout`  | string | 'vertical' | Layout: 'vertical' or 'horizontal'                            |

**Value format:** String (selected value).

### Button Group

Styled radio/checkbox alternative.

```php
// Single selection (radio-like)
Fields::button_group( 'alignment', $value, [
    'label'   => 'Alignment',
    'options' => [
        'left'   => 'Left',
        'center' => 'Center',
        'right'  => 'Right',
    ],
] );

// Multiple selection (checkbox-like)
Fields::button_group( 'formats', $value, [
    'label'    => 'Formats',
    'multiple' => true,
    'options'  => [
        'bold'   => 'B',
        'italic' => 'I',
        'under'  => 'U',
    ],
] );
```

**Options:**

| Option     | Type  | Default | Description                                                   |
|------------|-------|---------|---------------------------------------------------------------|
| `options`  | array | []      | Key-value pairs (value can be array with `label`, `disabled`) |
| `multiple` | bool  | false   | Allow multiple selection                                      |

**Value format:** String for single, array for multiple.

**Note:** Requires CSS/JS for styling. Enqueue via `wp_elements_enqueue()`.

### Toggle

Styled checkbox switch.

```php
Fields::toggle( 'notifications', $value, [
    'label'     => 'Enable Notifications',
    'on_label'  => 'On',
    'off_label' => 'Off',
] );
```

**Options:**

| Option      | Type   | Default | Description         |
|-------------|--------|---------|---------------------|
| `on_label`  | string | ''      | Text shown when on  |
| `off_label` | string | ''      | Text shown when off |

**Note:** Requires CSS for styling. Enqueue via `wp_elements_enqueue()`.

### Color

```php
Fields::color( 'brand_color', $value, [
    'label'   => 'Brand Color',
    'default' => '#3498db',
] );
```

**Options:**

| Option    | Type   | Default   | Description         |
|-----------|--------|-----------|---------------------|
| `default` | string | '#000000' | Default color (hex) |

**Value format:** Hex color string, e.g., `#ff0000`

### Date

```php
Fields::date( 'start_date', $value, [
    'label' => 'Start Date',
    'min'   => '2024-01-01',
    'max'   => '2024-12-31',
] );
```

**Options:**

| Option | Type   | Default | Description          |
|--------|--------|---------|----------------------|
| `min`  | string | null    | Minimum date (Y-m-d) |
| `max`  | string | null    | Maximum date (Y-m-d) |

**Value format:** `Y-m-d` string.

### Time

```php
Fields::time( 'start_time', $value, [
    'label' => 'Start Time',
    'min'   => '09:00',
    'max'   => '17:00',
    'step'  => 900,
] );
```

**Options:**

| Option | Type   | Default | Description                    |
|--------|--------|---------|--------------------------------|
| `min`  | string | null    | Minimum time (H:i)             |
| `max`  | string | null    | Maximum time (H:i)             |
| `step` | int    | null    | Step in seconds (900 = 15 min) |

**Value format:** `H:i` string.

### DateTime

```php
Fields::datetime( 'event_start', $value, [
    'label' => 'Event Start',
    'min'   => '2024-01-01T00:00',
    'max'   => '2024-12-31T23:59',
] );
```

**Options:**

| Option | Type   | Default | Description      |
|--------|--------|---------|------------------|
| `min`  | string | null    | Minimum datetime |
| `max`  | string | null    | Maximum datetime |
| `step` | int    | null    | Step in seconds  |

**Value format:** `Y-m-d\TH:i` string.

### Date Range

```php
Fields::date_range( 'event_dates', $value, [
    'label'       => 'Event Dates',
    'start_label' => 'From',
    'end_label'   => 'To',
    'separator'   => '→',
    'min'         => '2024-01-01',
    'max'         => '2024-12-31',
] );
```

**Options:**

| Option        | Type   | Default | Description           |
|---------------|--------|---------|-----------------------|
| `start_label` | string | 'Start' | Label for start field |
| `end_label`   | string | 'End'   | Label for end field   |
| `separator`   | string | '—'     | Text between fields   |
| `min`         | string | null    | Minimum date          |
| `max`         | string | null    | Maximum date          |

**Value format:** `['start' => '2024-06-01', 'end' => '2024-06-07']`

### Time Range

```php
Fields::time_range( 'business_hours', $value, [
    'label'       => 'Hours',
    'start_label' => 'Open',
    'end_label'   => 'Close',
    'separator'   => 'to',
    'step'        => 900,
] );
```

**Options:**

| Option        | Type   | Default | Description           |
|---------------|--------|---------|-----------------------|
| `start_label` | string | 'Start' | Label for start field |
| `end_label`   | string | 'End'   | Label for end field   |
| `separator`   | string | '—'     | Text between fields   |
| `min`         | string | null    | Minimum time          |
| `max`         | string | null    | Maximum time          |
| `step`        | int    | null    | Step in seconds       |

**Value format:** `['start' => '09:00', 'end' => '17:00']`

### Button

```php
Fields::button( 'Click Me', [
    'id'      => 'my-button',
    'primary' => true,
    'data'    => [ 'action' => 'do-something' ],
] );

Fields::submit( 'Save Changes' );
Fields::reset( 'Clear Form' );
```

**Options:**

| Option    | Type   | Default  | Description                        |
|-----------|--------|----------|------------------------------------|
| `type`    | string | 'button' | Button type: button, submit, reset |
| `primary` | bool   | false    | WordPress primary button style     |
| `small`   | bool   | false    | Small button size                  |
| `large`   | bool   | false    | Large button size                  |
| `name`    | string | ''       | Button name attribute              |
| `value`   | string | null     | Button value attribute             |

**Note:** Different signature - `Fields::button( $text, $options )` not `( $name, $value, $options )`.

---

## Compound Fields

### Dimensions

Width × Height input.

```php
Fields::dimensions( 'banner_size', $value, [
    'label'        => 'Banner Size',
    'width_label'  => 'W',
    'height_label' => 'H',
    'separator'    => '×',
    'unit'         => 'px',
    'min'          => 0,
    'max'          => 2000,
    'step'         => 1,
] );
```

**Options:**

| Option         | Type   | Default  | Description            |
|----------------|--------|----------|------------------------|
| `width_label`  | string | 'Width'  | Label for width field  |
| `height_label` | string | 'Height' | Label for height field |
| `separator`    | string | '×'      | Text between fields    |
| `unit`         | string | ''       | Unit displayed after   |
| `min`          | number | 0        | Minimum value          |
| `max`          | number | null     | Maximum value          |
| `step`         | number | 1        | Step increment         |

**Value format:** `['width' => 728, 'height' => 90]`

### Amount Type

Number with type selector (e.g., discount percent/flat).

```php
Fields::amount_type( 'discount', $value, [
    'label'        => 'Discount',
    'type_options' => [
        'percent' => '%',
        'flat'    => '$',
    ],
    'type_default' => 'percent',
    'min'          => 0,
    'max'          => 100,
    'step'         => 0.01,
] );
```

**Options:**

| Option         | Type   | Default | Description                       |
|----------------|--------|---------|-----------------------------------|
| `type_options` | array  | []      | Key-value pairs for type selector |
| `type_default` | string | null    | Default type (first key if null)  |
| `min`          | number | 0       | Minimum value                     |
| `max`          | number | null    | Maximum value                     |
| `step`         | number | 'any'   | Step increment                    |

**Value format:** `['amount' => 15, 'type' => 'percent']`

### Link

URL + title + target combined.

```php
Fields::link( 'cta_link', $value, [
    'label'           => 'Call to Action',
    'url_label'       => 'URL',
    'url_placeholder' => 'https://',
    'title_label'     => 'Link Text',
    'target_label'    => 'Open in new tab',
    'show_title'      => true,
    'show_target'     => true,
] );
```

**Options:**

| Option            | Type   | Default           | Description               |
|-------------------|--------|-------------------|---------------------------|
| `url_label`       | string | 'URL'             | Label for URL field       |
| `url_placeholder` | string | 'https://'        | Placeholder for URL       |
| `title_label`     | string | 'Link Text'       | Label for title field     |
| `target_label`    | string | 'Open in new tab' | Label for target checkbox |
| `show_title`      | bool   | true              | Show title field          |
| `show_target`     | bool   | true              | Show target checkbox      |

**Value format:** `['url' => 'https://...', 'title' => 'Learn More', 'target' => '_blank']`

### Price

Amount + currency selector.

```php
Fields::price( 'product_price', $value, [
    'label'             => 'Price',
    'currencies'        => [
        'USD' => 'USD ($)',
        'EUR' => 'EUR (€)',
        'GBP' => 'GBP (£)',
    ],
    'default_currency'  => 'USD',
    'currency_position' => 'before',
    'show_currency'     => true,
    'min'               => 0,
    'step'              => '0.01',
] );
```

**Options:**

| Option              | Type   | Default     | Description                   |
|---------------------|--------|-------------|-------------------------------|
| `currencies`        | array  | USD/EUR/GBP | Currency options              |
| `default_currency`  | string | 'USD'       | Default currency              |
| `currency_position` | string | 'before'    | Position: 'before' or 'after' |
| `show_currency`     | bool   | true        | Show currency selector        |
| `min`               | number | 0           | Minimum value                 |
| `max`               | number | null        | Maximum value                 |
| `step`              | number | '0.01'      | Step increment                |

**Value format:** `['amount' => 29.99, 'currency' => 'USD']`

### Number Unit

Number + unit selector (for CSS values, etc.).

```php
Fields::number_unit( 'margin', $value, [
    'label'        => 'Margin',
    'units'        => [
        'px'  => 'px',
        '%'   => '%',
        'em'  => 'em',
        'rem' => 'rem',
    ],
    'default_unit' => 'px',
    'min'          => 0,
    'step'         => 1,
] );
```

**Options:**

| Option         | Type   | Default     | Description    |
|----------------|--------|-------------|----------------|
| `units`        | array  | px/%/em/rem | Unit options   |
| `default_unit` | string | 'px'        | Default unit   |
| `min`          | number | null        | Minimum value  |
| `max`          | number | null        | Maximum value  |
| `step`         | number | 1           | Step increment |

**Value format:** `['value' => 20, 'unit' => 'px']`

---

## Common Options

All fields support these base options:

| Option        | Type   | Default | Description                        |
|---------------|--------|---------|------------------------------------|
| `id`          | string | auto    | HTML id (auto-generated from name) |
| `label`       | string | null    | Label text                         |
| `description` | string | null    | Help text below field              |
| `class`       | string | ''      | Additional CSS classes for input   |
| `wrapper`     | bool   | true    | Wrap in div with label/description |
| `required`    | bool   | false   | HTML5 required attribute           |
| `disabled`    | bool   | false   | HTML5 disabled attribute           |
| `readonly`    | bool   | false   | HTML5 readonly attribute           |
| `placeholder` | string | null    | Placeholder text                   |
| `data`        | array  | []      | Data attributes (auto-prefixed)    |
| `attrs`       | array  | []      | Any custom HTML attributes         |

## Data Attributes

Pass an array to `data` option - keys are auto-prefixed with `data-`:

```php
Fields::text( 'search', $value, [
    'data' => [
        'endpoint'  => '/api/search',
        'min-chars' => 3,
        'delay'     => 300,
    ],
] );
// Output: data-endpoint="/api/search" data-min-chars="3" data-delay="300"
```

## Custom HTML Attributes

Pass any HTML attributes via `attrs`:

```php
Fields::text( 'code', $value, [
    'attrs' => [
        'autocomplete'   => 'off',
        'spellcheck'     => 'false',
        'maxlength'      => 6,
        'pattern'        => '[0-9]{6}',
        'inputmode'      => 'numeric',
        'aria-label'     => 'Verification code',
    ],
] );
```

---

## Rendering Options

### Full Field (Default)

Renders with wrapper div, label, input, and description:

```php
echo Fields::text( 'email', $value, [
    'label'       => 'Email',
    'description' => 'Your email address',
] );
```

Output:

```html

<div class="form-field field-email">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="" class="regular-text"/>
    <p class="description">Your email address</p>
</div>
```

### Input Only

Get just the input element (no wrapper, label, or description):

```php
// Method 1: Call ->input()
echo Fields::text( 'email', $value )->input();

// Method 2: Set wrapper option
echo Fields::text( 'email', $value, [ 'wrapper' => false ] );
```

Output:

```html
<input type="email" id="email" name="email" value="" class="regular-text"/>
```

---

## Fields Factory API

### Static Methods

```php
use ArrayPress\Elements\Fields;

// Direct field creation (all 23 types have their own method)
Fields::text( $name, $value, $options );
Fields::select( $name, $value, $options );
Fields::checkbox( $name, $value, $options );
// ... etc

// Dynamic field creation
$field = Fields::create( 'text', $name, $value, $options );

// Check if type exists
if ( Fields::has( 'custom_type' ) ) { ... }

// Get all available types
$types = Fields::types();
// ['text', 'url', 'email', 'tel', 'password', 'hidden', 'textarea', 'number', 'range', 'select', ...]

// Register custom type
Fields::register( 'star_rating', MyStarRating::class );
```

### Field Instance Methods

```php
$field = Fields::text( 'email', $value, $options );

// Get full rendered HTML (wrapper + label + input + description)
echo $field->render();
echo $field; // Same as render() via __toString()

// Get just the input element
echo $field->input();
```

---

## Registering Custom Field Types

Extend the `Field` class and implement `render_input()`:

```php
use ArrayPress\Elements\Fields;
use ArrayPress\Elements\Field;
use ArrayPress\Elements\Element;

class StarRating extends Field {

    protected function get_type_defaults(): array {
        return [
            'max_stars' => 5,
            'icon'      => '★',
        ];
    }

    public function render_input(): string {
        $html = '<div class="star-rating">';
        
        for ( $i = 1; $i <= $this->options['max_stars']; $i++ ) {
            $checked = ( (int) $this->value >= $i );
            
            $html .= Element::create( 'label', [], 
                Element::create( 'input', [
                    'type'    => 'radio',
                    'name'    => $this->name,
                    'value'   => $i,
                    'checked' => $checked,
                ] )->render() . $this->options['icon']
            )->render();
        }
        
        $html .= '</div>';
        return $html;
    }
}

// Register
Fields::register( 'star_rating', StarRating::class );

// Use via create()
echo Fields::create( 'star_rating', 'rating', 4, [
    'label'     => 'Your Rating',
    'max_stars' => 5,
] );
```

### Field Base Class Properties

Available in your custom field class:

- `$this->name` - Field name attribute
- `$this->value` - Current field value
- `$this->options` - Merged options array (defaults + type defaults + user options)

### Field Base Class Methods

- `render_input()` - **Abstract** - Must implement, returns input HTML
- `get_type_defaults()` - Override to add type-specific default options
- `build_attributes( $extra )` - Build attribute array for Element::create()
- `sanitize_id( $string )` - Sanitize string for use as HTML id

---

## Using Element Class Directly

For custom HTML generation without the field wrapper system:

```php
use ArrayPress\Elements\Element;

// Static factory method
$div = Element::create( 'div', [
    'class' => 'my-wrapper',
    'id'    => 'container',
    'data'  => [ 'value' => 123 ],
], 'Content here' );

echo $div;
// <div class="my-wrapper" id="container" data-value="123">Content here</div>

// Constructor (same as create)
$div = new Element( 'div', [ 'class' => 'wrapper' ], 'Content' );
```

### Self-Closing Elements

Automatically detected for: `area`, `base`, `br`, `col`, `embed`, `hr`, `img`, `input`, `link`, `meta`, `param`,
`source`, `track`, `wbr`

```php
$input = Element::create( 'input', [
    'type'  => 'text',
    'name'  => 'field',
    'value' => 'test',
] );

echo $input;
// <input type="text" name="field" value="test" />
```

### Fluent Interface

```php
$element = Element::create( 'span' )
    ->set( 'id', 'my-span' )
    ->addClass( 'highlight' )
    ->addClass( 'important' )
    ->data( [ 'tooltip' => 'Hello', 'placement' => 'top' ] )
    ->content( 'Text content' );

echo $element;
// <span id="my-span" class="highlight important" data-tooltip="Hello" data-placement="top">Text content</span>
```

### Boolean Attributes

Values of `true` render as attribute only, `false` or `null` are omitted:

```php
$input = Element::create( 'input', [
    'type'     => 'checkbox',
    'checked'  => true,
    'disabled' => false,
    'required' => true,
] );
// <input type="checkbox" checked required />
```

### Element Methods

| Method                             | Description                         |
|------------------------------------|-------------------------------------|
| `create( $tag, $attrs, $content )` | Static factory                      |
| `set( $name, $value )`             | Set single attribute                |
| `addClass( $class )`               | Add CSS class(es), space-separated  |
| `data( $array )`                   | Add data attributes (auto-prefixed) |
| `content( $string )`               | Set inner content                   |
| `render()`                         | Get HTML string                     |
| `__toString()`                     | Allows `echo $element`              |

---

## Assets

Some fields (toggle, button_group, range) need CSS/JS to display properly. The library includes minimal assets:

```php
add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( $hook !== 'settings_page_my-plugin' ) {
        return;
    }
    
    wp_elements_enqueue();
} );
```

### What's Included

**CSS (`assets/css/wp-elements.css`):**

- Toggle switch styling (slider, checked state)
- Button group layout (flexbox, selection state)
- Range output display
- Checkbox/radio group layouts
- Compound field layouts (dimensions, price, link, etc.)

**JavaScript (`assets/js/wp-elements.js`):**

- Button group `.is-selected` class toggle
- Range slider live output update

**Note:** Fields work without assets, but toggles/button groups will look unstyled.

---

## Helper Functions

Two global functions are available (auto-loaded via Composer):

```php
// Enqueue library CSS and JS assets
wp_elements_enqueue();

// Render field without importing Fields class
echo wp_render_field( 'text', 'username', $value, [
    'label' => 'Username',
] );
```

---

## Requirements

- **PHP:** 7.4+
- **WordPress:** For escaping functions (`esc_attr`, `esc_html`, `esc_textarea`, `esc_url`)
- **Composer:** `arraypress/wp-composer-assets` for asset loading

## License

GPL-2.0-or-later
