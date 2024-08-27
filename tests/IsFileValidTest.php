<?php

namespace Php\Package\Tests;

use PHPUnit\Framework\TestCase;

use function DiffCalc\Diff\isFileValid;

class IsFileValidTest extends TestCase
{
    public function testIsFileValidReturnsFalseForNonExistentFile()
    {
        $this->assertFalse(isFileValid('nonExistentFile.txt'));
    }

    public function testIsFileValidReturnsFalseForNonJsonFile()
    {
        // This test requires a dummy text file named 'testFile.txt' to be present in the same directory
        $this->assertFalse(isFileValid('testFile.txt'));
    }

    public function testIsFileValidReturnsFalseForInvalidJsonFile()
    {
        // This test requires a dummy JSON file named 'invalidTestFile.json'
        // to be present in the same directory, and it contains invalid JSON data
        $this->assertFalse(isFileValid('invalidTestFile.json'));
    }

    public function testIsFileValidReturnsTrueForValidJsonFile()
    {
        // This test requires a dummy JSON file named 'validTestFile.json' to be present in the same directory
        $this->assertTrue(isFileValid('validTestFile.json'));
    }
}