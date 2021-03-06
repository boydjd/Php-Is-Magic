<?php

/*
 * Magic pattern example
 */

namespace tests\Trismegiste\Magic\Pattern\Composite\Example;

/**
 * ModelImpl is an implementation of ModelInterface
 */
trait ModelImpl
{

    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return '[' . $this->name . ']';
    }

}