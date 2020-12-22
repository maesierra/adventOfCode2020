<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day22Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day22.txt";
        $this->assertEquals(306, (new Day22())->question1($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day22.txt";
        $this->assertEquals(291, (new Day22())->question2($inputFile));
    }

    public function testQuestion2_recursive() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day22_2.txt";
        //We just want to test the any loop protection
        $this->assertGreaterThan(0, (new Day22())->question2($inputFile));
    }
}