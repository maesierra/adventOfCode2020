<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day9Test extends TestCase {

    public function testValidate() {
        $day9 = new Day9();
        $preamble = range(1, 25);
        $this->assertTrue($day9->validate($preamble, 26));
        $this->assertTrue($day9->validate($preamble, 49));
        $this->assertFalse($day9->validate($preamble, 50));
        $this->assertFalse($day9->validate($preamble, 100));
    }

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day9.txt";
        $this->assertEquals(127, (new Day9())->question1($inputFile, 5));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day9.txt";
        $this->assertEquals(62, (new Day9())->question2($inputFile, 127));
    }
}