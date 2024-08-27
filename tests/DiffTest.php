<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Diff\gendiff;

class DiffTest extends TestCase
{
    public function testDiff()
    {
        $result = file_get_contents(__DIR__ . '/../fixtures/result.txt');
        $pathToFile1 = __DIR__ . '/../fixtures/file1.json';
        $pathToFile2 = __DIR__ . '/../fixtures/file2.json';

        $this->assertEquals(gendiff($pathToFile1, $pathToFile2), $result);
    }
}
