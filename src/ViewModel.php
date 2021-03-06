<?php
/**
 * Created by PhpStorm.
 * User: jasurbek
 * Date: 2019-09-18
 * Time: 11:19
 */

namespace jascoB\ViewModel;


use Closure;
use jascoB\ViewModel\Interfaces\Arrayable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

abstract class ViewModel implements Arrayable
{
    /**
     * @var array $ignore this is ignored functions list
     */
    protected $ignore = [];

    /**
     * @var string
     */
    protected $view = '';

    /**
     * @var $_class ReflectionClass
     */
    private $_class;

    /**
     * @var array $_items items for return
     */
    private $_items = [];

    public function toArray()
    {
        return $this->items();
    }

    protected function items()
    {
        if (!$this->_items) {
            $propertyVariables = $this->getPropertyVariables();
            $methodVariables = $this->getMethodVariables();
            $this->_items = array_merge($propertyVariables, $methodVariables);
        }

        return $this->_items;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getPropertyVariables()
    {
        $class = $this->getClass();
        $publicProperties = $class->getProperties(ReflectionProperty::IS_PUBLIC);

        $filteredProperties = $this->filterProperties($publicProperties);

        $filteredPropertiesWithKeys = [];

        foreach ($filteredProperties as $filteredProperty) {
            $filteredPropertiesWithKeys[$filteredProperty->getName()] = $this->{$filteredProperty->getName()};
        }
        return $filteredPropertiesWithKeys;
    }

    /**
     * @return ReflectionClass
     * @throws \ReflectionException
     */
    protected function getClass()
    {
        if (!$this->_class) {
            $this->_class = new ReflectionClass($this);
        }

        return $this->_class;
    }

    /**
     * @param $items
     * @return ReflectionProperty []
     */
    protected function filterProperties($items)
    {
        return array_filter($items, function (ReflectionProperty $property) {
            return !$this->isIgnored($property->getName());
        });
    }

    /**
     * @param $methodName string method name or property name
     * @return bool
     */
    protected function isIgnored($methodName)
    {
        if (strpos($methodName, '__') === 0) {
            return true;
        }

        return in_array($methodName, $this->ignoredMethods());
    }


    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function getMethodVariables()
    {
        $class = $this->getClass();
        $publicMethods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        $filteredMethods = $this->filterMethods($publicMethods);

        $filteredMethodsWithKeys = [];

        foreach ($filteredMethods as $filteredMethod) {
            $filteredMethodsWithKeys[$filteredMethod->getName()] = $this->createVariableFromMethod($filteredMethod);
        }

        return $filteredMethodsWithKeys;
    }

    /**
     * @param $items
     * @return ReflectionMethod []
     */
    protected function filterMethods($items)
    {
        return array_filter($items, function (ReflectionMethod $method) {
            return !$this->isIgnored($method->getName());
        });
    }

    /**
     * ignored methods list
     * @return array
     */
    protected function ignoredMethods(): array
    {
        return array_merge([
            'toArray',
            'filterProperties',
            'getClass',
            'filterMethods',
            'items',
            'offsetExists',
            'offsetGet',
            'offsetSet',
            'offsetUnset',
        ], $this->ignore);
    }

    protected function createVariableFromMethod(ReflectionMethod $method)
    {
        if ($method->getNumberOfParameters() === 0) {
            return $this->{$method->getName()}();
        }
        return Closure::fromCallable([$this, $method->getName()]);
    }

}
