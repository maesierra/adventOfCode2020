<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day7Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day7.txt";
        $this->assertEquals(4, (new Day7())->question1($inputFile));
    }

    public function testQuestion2() {
        $this->assertEquals(32, (new Day7())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day7.txt"));
        $this->assertEquals(126, (new Day7())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day7_2.txt"));
    }
}