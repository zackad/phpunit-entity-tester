<?php

namespace Zackad\PhpUnitEntityTester\Fixtures\Entity;

/**
 * Class Entity
 * @package PhpUnitEntityTester\Fixtures\Entity
 */
class Entity
{
    /**
     * @var
     */
    protected $name;

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param $name
     */
    public function setNameNotFluent($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSpecialName()
    {
        return $this->name . 'Special';
    }

    /**
     * @return string
     */
    public function badGetMethod()
    {
        return $this->name . 'wrong_data';
    }
}
