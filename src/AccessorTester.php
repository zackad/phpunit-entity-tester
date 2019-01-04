<?php

namespace PhpUnitEntityTester;

use \PHPUnit\Framework\TestCase;

/**
 * Class AccessorTester
 * @package PhpUnitEntityTester
 */
class AccessorTester
{
    /**
     *
     */
    const USE_SET_DATA = 'USE_SET_DATA';

    /**
     * @var string
     */
    public static $MSG_SETTER_METHOD_NOT_FLUENT = "The method '%setterMethod%' is not fluent.";
    /**
     * @var string
     */
    public static $MSG_GETTER_METHOD_BAD_RETURN = "The method '%getterMethod%' does not return the good value.";

    /**
     * @var
     */
    protected $entity;
    /**
     * @var
     */
    protected $attribute;
    /**
     * @var bool
     */
    protected $fluent;
    /**
     * @var string
     */
    protected $setterMethod;
    /**
     * @var string
     */
    protected $getterMethod;

    /**
     * AccessorTester constructor.
     * @param $entity
     * @param $attribute
     */
    public function __construct(
        $entity,
        $attribute
    ) {
        $this->entity = $entity;
        $this->attribute = $attribute;

        $this->fluent = true;

        $this->setterMethod = 'set' . ucfirst($attribute);
        $this->getterMethod = 'get' . ucfirst($attribute);
    }

    /**
     * @param $fluent
     * @return $this
     */
    public function fluent($fluent): self
    {
        $this->fluent = $fluent;

        return $this;
    }

    /**
     * @param $setterMethod
     * @return $this
     */
    public function setterMethod(string $setterMethod): self
    {
        $this->setterMethod = $setterMethod;

        return $this;
    }

    /**
     * @param $getterMethod
     * @return $this
     */
    public function getterMethod(string $getterMethod): self
    {
        $this->getterMethod = $getterMethod;

        return $this;
    }

    /**
     * @param $setData
     * @param string $getData
     * @return $this
     */
    public function test($setData, string $getData = self::USE_SET_DATA): self
    {
        $getData = $getData === self::USE_SET_DATA ? $setData : $getData;

        $this->testSetter($setData);
        $this->testGetter($getData);

        return $this;
    }

    /**
     * @param $data
     */
    private function testSetter($data): void
    {
        $setterMethod = $this->setterMethod;

        $returnOfSetter = $this->entity->$setterMethod($data);

        if ($this->fluent) {
            TestCase::assertEquals(
                $this->entity,
                $returnOfSetter,
                $this->msg(self::$MSG_SETTER_METHOD_NOT_FLUENT)
            );
        }
    }

    /**
     * @param $data
     */
    private function testGetter($data): void
    {
        $getterMethod = $this->getterMethod;

        TestCase::assertEquals(
            $data,
            $this->entity->$getterMethod(),
            $this->msg(self::$MSG_GETTER_METHOD_BAD_RETURN)
        );
    }

    /**
     * @param $msg
     * @return mixed
     */
    private function msg($msg): string
    {
        $replaces = [
            '%setterMethod%' => $this->setterMethod,
            '%getterMethod%' => $this->getterMethod
        ];

        foreach ($replaces as $key => $value) {
            $msg = str_replace($key, $value, $msg);
        }

        return $msg;
    }
}

