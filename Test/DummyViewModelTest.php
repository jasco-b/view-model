<?php

namespace jascoB\ViewModel\Test;


use PHPUnit\Framework\TestCase;

class DummyViewModelTest extends TestCase
{

    const DOMMY_MODEL_CONSTRUCT_ATTR = 'testConstruct';

    /**
     * @return array
     */
    public function createDummyModal()
    {
        $dummyModel = new DummyViewModel(self::DOMMY_MODEL_CONSTRUCT_ATTR);

        return $dummyModel->toArray();
    }


    public function testResultIsArray()
    {
        $model = $this->createDummyModal();

        $this->assertIsArray(($model), 'Output is not array');


        $this->assertNotEmpty($model, 'output array is empty');

    }

    public function testViewModelProperties()
    {
        $model = $this->createDummyModal();

        $this->assertArrayHasKey('publicModel', $model, 'public attribute key does not exists');

        $this->assertEquals(true, $model['publicModel'],'public attribute wrong value');

        $this->assertArrayNotHasKey('protectedModel', $model, 'protected attribute key does  exists');
        $this->assertArrayNotHasKey('privateModel', $model, 'private attribute key does  exists');

    }


    public function testViewModelFunctions()
    {
        $model = $this->createDummyModal();

        $this->assertArrayHasKey('publicFunction', $model, 'public function key does not exists');

        $this->assertEquals(true, $model['publicFunction'],'public function Wrong value');

        $this->assertArrayNotHasKey('protectedFunction', $model, 'protected function key does  exists');
        $this->assertArrayNotHasKey('privateFunction', $model, 'private function key does  exists');
    }


    public function testViewModelFunctionsWithArgument()
    {
        $model = $this->createDummyModal();

        $this->assertArrayHasKey('publicFunctionWithArgument', $model, 'public function with argument key does not exists');

        $this->assertEquals(2, $model['publicFunctionWithArgument'](2), 'public function with argument Wrong value');

        $this->assertArrayNotHasKey('protectedFunctionWithArgument', $model, 'protected function with argument key does  exists');
        $this->assertArrayNotHasKey('privateFunctionWithArgument', $model, 'private function  with argument key does  exists');
    }

    public function testIgnoredValue()
    {
        $model = $this->createDummyModal();

        $this->assertArrayNotHasKey('ignoredProperty', $model, 'has ignored property');

        $this->assertArrayNotHasKey('thisIsIgnored', $model, 'has ignored function');

        $this->assertArrayNotHasKey('ignoredMethodWithArgument', $model, 'has ignored function with argument');

    }


}
