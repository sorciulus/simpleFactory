This library has been designed to make it easy to generate value objects. You can set the parameters of the object without knowing in what order it is passed to the constructor. This library will be useful if you have so many parameters to pass to the constructor.

## Installation

Via [Composer](http://getcomposer.org/):

```
composer require sorciulus/SimpleFactory
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

License
----
This Library is released under the MIT License. Please see License File for more information.