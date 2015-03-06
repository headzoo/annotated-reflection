<?php
namespace Headzoo\Reflection\Annotation\Headzoo;

abstract class AbstractAnnotation
{
    /**
     * @var string
     */
    protected $value;
    
    /**
     * @param array $values
     */
    public function __construct($values)
    {
        foreach($values as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}