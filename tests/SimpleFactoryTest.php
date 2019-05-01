<?php

/*
 * This file is part of SimpleFactory.
 *
 * (c) Corrado Ronci <sorciulus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleFactory\Tests;

use PHPUnit\Framework\TestCase;
use SimpleFactory\SimpleFactory;
use SimpleFactory\Tests\Objects;

class SimpleFactoryTest extends TestCase
{
    public function testSimpleFactoryConstructInvalidArgumentExceptionException()
    {
        $this->expectException(\InvalidArgumentException::class);
        new SimpleFactory('Objects\Publisher');
    }

    public function testFactoryPublisherAssertTrue()
    {
        $object = new SimpleFactory(Objects\Publisher::class);
        $object->setName('TestPublisher');
        $this->assertInstanceOf(Objects\Publisher::class, $object->make());
    }

    public function testFactoryPublisherValidatesArgsForMagicMethods()
    {
        $object = new SimpleFactory(Objects\Publisher::class);
        $object->setName('TestPublisher');
        $publisher = $object->make();
        $this->assertEquals('TestPublisher', $publisher->getName());
    }

    public function testFactoryPublisherInvalidArgumentExceptionException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $object = new SimpleFactory(Objects\Publisher::class);
        $object->setName(102800);
        $object->make();
    }

    public function testFactoryBookValidatesObjectForMagicMethods()
    {
        $object = new SimpleFactory(Objects\Book::class);
        $object
            ->setPublisher(new Objects\Publisher('TestPublisher'))
            ->setYear(2001)
            ->setRating(8.1)
        ;
        $book = $object->make();
        $this->assertInstanceOf(Objects\Publisher::class, $book->getPublisher());
    }

    public function testFactorySetWrogParameterBadMethodCallException()
    {
        $this->expectException(\BadMethodCallException::class);
        $object = new SimpleFactory(Objects\Book::class);
        $object->setCoverColor('white');
    }

    public function testFactoryWithMethodAssertTrue()
    {
        $publisher = (new SimpleFactory(Objects\Publisher::class))->setName('TestPublisher')->make();
        $object    = new SimpleFactory(Objects\Publisher::class);
        $object->with($publisher);
        $this->assertEquals($publisher, $object->make());
    }

    public function testFactoryWithMethodInvalidArgumentExceptionException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $publisher = (new SimpleFactory(Objects\Publisher::class))->setName('TestPublisher')->make();
        $object    = new SimpleFactory(Objects\Book::class);
        $object->with($publisher);
    }

    public function testFactoryResolveInjectionDependecyAssertTrue()
    {
        $object = new SimpleFactory(Objects\Book::class);
        $this->assertInstanceOf(Objects\Book::class, $object->make());
    }
}
