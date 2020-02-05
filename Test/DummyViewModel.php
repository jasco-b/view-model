<?php

namespace jascoB\ViewModel\Test;

use jascoB\ViewModel\ViewModel;

class DummyViewModel extends ViewModel
{
    protected $ignore = [
        'ignoredProperty',
        'thisIsIgnored',
        'ignoredMethodWithArgument'
    ];

    public $ignoredProperty;

    public $constructAttribute;

    public $publicModel = true;

    protected $protectedModel = true;

    private $privateModel = true;

    public function __construct($attribute)
    {
        $this->constructAttribute = $attribute;
    }

    public function publicFunction()
    {
        return true;
    }

    protected function protectedFunction()
    {
        return true;
    }

    private function privateFunction()
    {
        return true;
    }


    public function publicFunctionWithArgument($number)
    {
        return $number;
    }


    protected function protectedFunctionWithArgument($number)
    {
        return $number;
    }

    private function privateFunctionWithArgument($number)
    {
        return $number;
    }

    public function __get($name)
    {
        return true;
    }

    public function thisIsIgnored()
    {
        return true;
    }

    public function ignoredMethodWithArgument($test)
    {
        return $test;
    }


}
