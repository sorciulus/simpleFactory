<?php

/*
 * This file is part of SimpleFactory.
 *
 * (c) Corrado Ronci <sorciulus@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SimpleFactory;

class SimpleFactory
{
    /**
     * The class to factory
     *
     * @var string
     */
    private $class;

    /**
     * The class reflaction
     *
     * @var ReflectionClass
     */
    private $reflactionClass;

    /**
     * The parameters of class
     *
     * @var array
     */
    private $parameters = [];

    public function __construct(string $object)
    {
        if (!class_exists($object)) {
            throw new \InvalidArgumentException(\sprintf('The class %s not exits', $object));
        }
        
        $this->class = $object;
        $this->makeReflection();
    }

    /**
     * This method return an instance of property class
     *
     * @return object
     */
    public function make()
    {
        return $this->reflactionClass->newInstanceArgs($this->setInstanceParameters());
    }

    /**
     * This method overwrite the parameter with class instantiated
     *
     * @param object $object
     * @return self
     */
    public function with(object $object) : self
    {
        if (!$object instanceof $this->class) {
            throw new \InvalidArgumentException(\sprintf('The object class must be instance of %s', $this->class));
        }

        foreach ($this->reflactionClass->getMethods() as $method) {
            $param = strtolower(str_replace('get', '', $method->getName()));
            foreach ($this->reflactionArgsClass as $arg) {
                if ($arg->getName() === $param) {
                    $value = $object->{$method->getName()}();
                    $this->parameters[$param] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * The magic method will be use to set parameter of class,
     * if the parameter has a type this method validate the parameter
     *
     * @param string $name
     * @param array $arguments
     * @return self
     */
    public function __call($name, $arguments) : self
    {
        if (strpos($name, 'set') > -1) {
            $param = strtolower(str_replace('set', '', $name));
            $reflectionParam = null;
            foreach ($this->reflactionArgsClass as $arg) {
                if ($arg->getName() === $param) {
                    if ($arg->hasType()) {
                        if (gettype(current($arguments)) === 'object') {
                            $class = $arg->getType()->getName();
                            if (current($arguments) instanceof $class) {
                                $reflectionParam = current($arguments);
                                continue;
                            }
                        }
                        $argType = $this->normalizeTypeReflection($arg->getType()->getName());
                        if (gettype(current($arguments)) !== $argType) {
                            throw new \InvalidArgumentException(\sprintf('The parameter %s of %s class must be of the type %s', $param, $this->class, $argType));
                        }
                    }

                    $reflectionParam = current($arguments);
                }
            }

            if (is_null($reflectionParam)) {
                throw new \BadMethodCallException(\sprintf('The parameter %s of %s class doesn\'t exist', $param, $this->class));
            }
            
            if (!is_null($reflectionParam)) {
                $this->parameters[$param] = $reflectionParam;
            }
        }

        return $this;
    }

    /**
     * Reflection Class
     *
     * @return void
     */
    private function makeReflection()
    {
        $this->reflactionClass = new \ReflectionClass($this->class);
        $this->reflactionArgsClass = $this->reflactionClass->getConstructor()->getParameters();
    }

    /**
     * This method prepare parameter of reflection class
     * for new instance. By default set paramter of null,
     * if parameter has class try to set parameter to empty
     * class instance.
     * If parameter has changed replace parameter with new value.
     *
     * @return array
     */
    private function setInstanceParameters() : array
    {
        $parameters = [];
        foreach ($this->reflactionArgsClass as $arg) {
            if (\array_key_exists($arg->getName(), $this->parameters)) {
                $parameters[$arg->getName()] = $this->parameters[$arg->getName()];
                continue;
            }

            if (class_exists($arg->getType()->getName())) {
                $parameters[$arg->getName()] = (new self($arg->getType()->getName()))->make();
                continue;
            }

            $parameters[$arg->getName()] = null;
        }

        return $parameters;
    }

    /**
     * This function normalize reflection argument type
     * with gettype php function
     *
     * @param string $type
     * @return string
     */
    private function normalizeTypeReflection($type) : string
    {
        switch ($type) {
            case 'int':
                return 'integer';
            case 'float':
                return 'double';
            default:
                return $type;
        }
    }
}
