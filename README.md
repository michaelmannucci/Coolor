# Statamic Modifier: Coolor

Make your colors coolor with Cooler. Built with [PHPColors](https://github.com/mexitek/phpColors).

## What is it

A modifier that can manipulate the hue, saturation, and/or luminance of any given color. It works by converting the HEX to HSL, making the chnages you specify, and returning the new HEX value. It can be used with the [color fieldtype](https://www.statamic.dev/fieldtypes/color) or with manual input.

## What is it for

Generating variants of a color. For example, you could select a single color in the dashboard, and then generate a 10% lighter variant of it for hover states, a 5% luminance level/5% saturation level variant for body text, a 95% luminance level/5% luminance level variant for tinted off-white backgrounds, etc.

## How to install it

Install via composer or the Control Panel.

```bash
composer require michaelmannucci/coolor
```

## How to use it

### Color Manipulation Parameters

*Coolor* has 8 different color manipulation parameters:

#### 1. `addhue`

Used to increase the hue value of a color. 

Since the hue of a color is a 360° loop, it's helpful to think of this as how much degrees you want to add to the hue. For example, if you wanted a 120° variant of `your_color`, you would do:

`{{ your_color | coolor:addhue:120 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#9eff26">#9eff26</span>** in return.

#### 2. `subhue`

This is the same as `addhue`, except it subtracts from the hue value of a color.

For example, if you wanted a -75° variant of `your_color`, you would do:

`{{ your_color | coolor:subhue:75 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#5024ff">#5024ff</span>** in return.

#### 3. `lum`

Used to set the luminance value of a color.

0 is black (#000000), and 100 is white (#ffffff).

For example, if you wanted a variation of `your_color` that has a luminance level of 10 (very dark), you would do:

`{{ your_color | coolor:lum:10 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#33001c">#33001c</span>** in return.

#### 4. `tint`

Used to generate a brighter variant of a color.

The difference between `tint` and `lum` is `lum` sets the luminance level to whatever value you enter, whereas `tint` increases the lumenance level by the percentage value you enter.

For example, if you wanted a variation of `your_color` that was 10% brighter:

`{{ your_color | coolor:tint:10 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#ff3ca8">#ff3ca8</span>** in return.

#### 5. `shade`

Used to generate a darker variant of a color.

For example, if you wanted a variation of `your_color` that was 20% darker:

`{{ your_color | coolor:shade:20 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#cc1e7e">#cc1e7e</span>** in return.

#### 6. `sat`

Used to set the saturation value of a color.

For example, if you wanted a variation of `your_color` that has a saturation level of 10, you would do:

`{{ your_color | coolor:sat:10 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#9d8894">#9d8894</span>** in return.

#### 7. `addsat`

Used to generate a more saturated variant of a color.

The difference between `addsat` and `sat` is `sat` sets the saturation level to whatever value you enter, whereas `addsat` increases the saturation level by the percentage value you enter.

For example, if you wanted a variation of `your_color` that was 25% more saturated:

`{{ your_color | coolor:addsat:25 }}`

So, if `your_color` was **<span style="color:#c85b97">#c85b97</span>**, you would get **<span style="color:#e3409a">#e3409a</span>** in return.

#### 8. `subsat`

Used to generate a less saturated variant of a color.

For example, if you wanted a variation of `your_color` that was 50% less saturated:

`{{ your_color | coolor:subsat:50 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#c95c98">#c95c98</span>** in return.

### Mixing Manipulations

Of course, you can also mix any of the parameters.

For example, if you wanted a 90° hue variation of `your_color` that was 50% less saturated, with a luminance level of 10, you would do:

`{{ your_color | coolor:addhue:90:subsat:50:lum:10 }}`

So, if `your_color` was **<span style="color:#ff269e">#ff269e</span>**, you would get **<span style="color:#736f26">#736f26</span>** in return.

## Use Case & Tailwind CSS

Okay, so let's see a practical use case. Let's say you want to generate 4 variations of a color from the dashboard for use with Tailwind CSS in your themes. You want:

- Primary (the color as is)
- Hover (for hovering over buttons and such)
- Dark (for body text that is almost black, but has a hint of your color)
- Light (for off-white elements that have a hint of your color)

### Follow these steps:

#### 1. In your `layout.antlers.html`, under the opening `<body>` tag, enter this code:

```
<style>
    :root{
        --brand-primary:{{ your_color }};
        --brand-hover:{{ your_color | coolor:tint:10 }};
        --brand-dark:{{ your_color | coolor:sat:15:lum:10 }};
        --brand-light:{{ your_color | coolor:sat:5:lum:90 }};
    }
</style>

```

If `your_color` is **<span style="color:#ff269e">#ff269e</span>**, the above will output the following HTML:

```
<style>
    :root{
        --brand-primary:#ff269e;
        --brand-hover:#ff3ca8;
        --brand-dark:#1d161a;
        --brand-light:#e7e4e6;
    }
</style>

```

This uses a [`:root` css pseudo class](https://developer.mozilla.org/en-US/docs/Web/CSS/:root), a workaround to use Statamic variables inside your `tailwind.config.js` file.

#### 2. Add the following to your `tailwind.config.js` file.

```
module.exports = {
  theme: {
    extend: {
      colors: {
        'brand': {
          primary: 'var(--brand-primary)',
          hover: 'var(--brand-hover)',
          dark: 'var(--brand-dark)',
          light: 'var(--brand-light)'
        },
      }
    },
  },
}
```

You can now use this color palette in all Tailwind CSS color utilities (eg. `border-brand-primary`, `bg-brand-light`, etc.).

#### 3. Create a safelist.

This part sucks, but Tailwind isn't going to see your colors because they're not actually in the templates, the tags are. In order to make sure they're included, create a safelist.

There's a few ways to do this, but what I found easiest is to create a `safelist.txt` in the root folder with all the styles I want to make sure it keeps (eg. bg-brand-primary) and add it to the `content` section of `tailwind.config.js`, like so:

```
content: [
    './resources/**/*.antlers.html',
    './resources/**/*.blade.php',
    './resources/**/*.vue',
    './content/**/*.md',
    './safelist.txt'
  ],
  ```