Simple Factory
=======================


[![Packagist](https://img.shields.io/badge/packagist-2.1.8-lightgrey.svg)](https://packagist.org/packages/sorciulus/simpleFactory) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sorciulus/simpleFactory/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sorciulus/simpleFactory/?branch=master) [![Code Intelligence Status](https://scrutinizer-ci.com/g/sorciulus/simpleFactory/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence) [![Maintainability](https://api.codeclimate.com/v1/badges/6533365650a6255c78e5/maintainability)](https://codeclimate.com/github/sorciulus/simpleFactory/maintainability) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)[![Build Status](https://scrutinizer-ci.com/g/sorciulus/simpleFactory/badges/build.png?b=master)](https://scrutinizer-ci.com/g/sorciulus/simpleFactory/build-status/master)

This library has been designed to make it easy to generate value objects. You can set the parameters of the object without knowing in what order it is passed to the constructor. This library will be useful if you have so many parameters to pass to the constructor. By default all parameter will be set to null. If parameter is class (dependency injection) this library will attempt to create an empty object and pass it as a parameter.
 
## Installation

Via [Composer](http://getcomposer.org/):

```
composer require sorciulus/simple-factory
```
## Usage

```php
<?php
require_once 'vendor/autoload.php';

use SimpleFactory\SimpleFactory;

class Publisher
{
    /**
     * The name of publisher
     *
     * @var string
     */
    private $name;

    /**
     * The city of publisher
     *
     * @var string|null
     */
    private $city;

    /**
     * @param string $name
     */
    public function __construct(string $name, ?string $city)
    {
        $this->name = $name;
    }

    /**
     * Get the name of publisher
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get the city of publisher
     *
     * @return string|null
     */
    public function getCity() :?string
    {
        return $this->city;
    }
}

$factory   = new SimpleFactory(Publisher::class);
$publisher = $factory->setName('MyPublisher')->setCity('London')->make();

```
You can factory object by the same initialized object, all property setter will be set at new factory object

```php

$otherFactory = new SimpleFactory(Publisher::class);
$newPublisher = $otherFactory->with($publisher)->make();

```

If you want to set all the missing parameters to null, pass as a true parameter in the constructor

```php

$otherFactory = new SimpleFactory(Publisher::class, true);
$newPublisher = $otherFactory->make();

```

In alternative you can create a factory object from static method create

```php

$newPublisher = SimpleFactory::create(Publisher::class)->setName('MyPublisher')->setCity('London')->make();

```

License
----
This Library is released under the MIT License. Please see License File for more information.
