# DocHeader

[![Build Status](https://travis-ci.org/malukenho/docheader.svg?branch=master)](https://travis-ci.org/malukenho/docheader)
[![Code Coverage](https://scrutinizer-ci.com/g/malukenho/docheader/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/malukenho/docheader/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/malukenho/docheader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/malukenho/docheader/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/malukenho/docheader/v/stable)](https://packagist.org/packages/malukenho/docheader)
[![Total Downloads](https://poser.pugx.org/malukenho/docheader/downloads)](https://packagist.org/packages/malukenho/docheader)
[![Latest Unstable Version](https://poser.pugx.org/malukenho/docheader/v/unstable)](https://packagist.org/packages/malukenho/docheader)
[![License](https://poser.pugx.org/malukenho/docheader/license)](https://packagist.org/packages/malukenho/docheader)

How much time we have wasted to change copyright years in our project?
How much times we forget to update it and then we're in the middle of 
a new year using last year copyright dated? *That's sucks!!one!!*

**Put doc header check in your build and get it out of your way!**

### Installing

```sh
 composer require --dev --sort-packages malukenho/docheader
```

### Setting up

Put your header in one `.docheader` file in the directory that you're
running the checker/fixer. It file must contain only the dockblock as 
you want, like following example:

```php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
```

and then run the checker:

```sh
./vendor/bin/docheader check src/
```

So, you get errors or a message saying that everything is ok!

# Docheader file

By default, the `docheader` search for a `.docheader` file on the current directory that 
the command is executed. But you can specify a folder or a file to be used as placeholder
using the option `--docheader [file-or-path]`

# Current year placeholder

You can also put `%year%` on your `.docheader` file to refer to the current
Year, like that:

```php
/**
 * @copyright Copyright (c) 2005-%year% Zend Technologies USA Inc. (http://www.zend.com)
 */
```

# Regexp assertion

If you're using `>=0.1.5` version, you can use the `%regexp:%` placeholder to match some content.

Example:

```php
/**
 * @copyright Copyright (c) 20%regexp:\d{2}%-2016 Zend Technologies USA Inc. (http://www.zend.com)
 */
```

In this case `%regexp:\d{2}%` assert that it should be a number of two digits between `20` and `-`.
