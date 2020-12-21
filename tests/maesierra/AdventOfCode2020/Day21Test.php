<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day21Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day21.txt";
        $this->assertEquals(5, (new Day21())->question1($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day21.txt";
        $this->assertEquals("mxmxvkd,sqjhc,fvjkl", (new Day21())->question2($inputFile));
    }
}