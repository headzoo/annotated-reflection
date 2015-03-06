# Annotated Reflection
A mash-up of PHP's reflection library and Doctrine's annotation library.

[![Build Status](https://travis-ci.org/headzoo/annotated-reflection.svg?branch=master)](https://travis-ci.org/headzoo/annotated-reflection)
[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/headzoo/annotated-reflection/master/LICENSE.md)

### Installing via Composer

The recommended way to install headzoo/annotated-reflection is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Add headzoo/annotated-reflection to your composer.json:

```javascript
"require": {
	"headzoo/annotated-reflection": "dev-master"
}
```

Or run the Composer command to install the latest stable version of headzoo/annotated-reflection:

```bash
composer require headzoo/annotated-reflection
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```
