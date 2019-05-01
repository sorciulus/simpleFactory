<?php

namespace SimpleFactory\Tests\Objects;

class Publisher
{
    /**
     * The name of publisher
     *
     * @var string|null
     */
    private $name;

    /**
     * @param string|null $name
     */
    public function __construct(?string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the name of publisher
     *
     * @return string|null
     */
    public function getName() :?string
    {
        return $this->name;
    }
}
