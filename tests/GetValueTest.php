<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Diff\getValue;

class GetValueTest extends TestCase
{
    public function testGetValueReturnsStringWhenKeyExists()
    {
        $fileContent = ['testKey' => 'testValue'];
        $this->assertSame('testValue', getValue($fileContent, 'testKey'));
    }

    public function testGetValueReturnsBooleanStringWhenKeyIsBoolean()
    {
        $fileContent = ['testKey' => true, 'testKey2' => false];
        $this->assertSame('true', getValue($fileContent, 'testKey'));
        $this->assertSame('false', getValue($fileContent, 'testKey2'));
    }

    public function testGetValueReturnsNullWhenKeyDoesNotExist()
    {
        $fileContent = ['testKey' => 'testValue'];
        $this->assertNull(getValue($fileContent, 'nonExistentKey'));
    }
}