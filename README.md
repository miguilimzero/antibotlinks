# AntiBotLinks

AntiBotLinks is an easy to install self-hosted image captcha library. Through a predefined dictionary, the library generates images that must be selected in a specific order.

> Note: Currently this package uses the Laravel Cache driver to store data. For this reason, you may find it difficult to use this package in a project that is not a Laravel project.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Generate Links](#generate-links)
- [Validate Answer](#validate-answer)
- [Flush Links](#flush-links)
- [Customize Options](#customize-options)
- [License](#license)

## Installation

You can install the package via composer:

```sh
composer require srdante/antibotlinks
```

## Usage

To get started with the package, you must use the `make()` static method and pass as first parameter an identifier string. This identifier parameter will be used to store & get the generated challenge and solution (generally you should use the User ID, IP Address, or a generated cookie).

```php
Use Srdante\AntiBotLinks\AntiBotLinks;

$antibotlinks = AntiBotLinks::make('1');

var_dump($antibotlinks->generateLinks());

```

## Generate Links

You can generate / retrieve captcha links using the `generateLinks()` method. You can pass as first parameter the amount of links to generate. This method gets the generated links value from the cache, and generate if links are not found.

```php
$links = $antibotlinks->generateLinks(amount: 3);
```

## Validate Answer

You can validate the user answer with the `validateAnswer()` method.

```php
$antibotlinks->validateAnswer($answer);
```

## Flush Links

You can flush the current cache value and force re-generate a new captcha challenge. *It's highly recommended to use this method when the user sends a wrong a answer.*

```php
$antibotlinks->flushLinks();
```

## Customize Options

There are some few options that you can enable / disable when generating AntiBotLinks image.

```php
// Enable or Disable image noise (Default: true)
$antibotlinks->noise(value: false);

// Enable or Disable image background (Default: false)
$antibotlinks->background(value: true);

// Enable or Disable dark theme (Default: false)
$antibotlinks->darkTheme(value: true);
```

You can also customize the word universe. You can overwrite the word universe or merge your array with the default one.

```php
$wordUniverse = [...];

$antibotlinks->wordUniverse($wordUniverse);
// Or...
$antibotlinks->mergeWordUniverse($wordUniverse);
```

## License

AntiBotLinks is open-sourced software licensed under the [MIT license](LICENSE).

> This Library is inspired by "AntiBotLinks" from FBU Script created by MakeJar.