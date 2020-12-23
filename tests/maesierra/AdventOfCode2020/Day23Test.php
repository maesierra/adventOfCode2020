<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day23Test extends TestCase {

    public function testQuestion1_10moves() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day23.txt";
        $this->assertEquals("92658374", (new Day23())->question1($inputFile, 10));
    }

    public function testQuestion1_100moves() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day23.txt";
        $this->assertEquals("67384529", (new Day23())->question1($inputFile, 100));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day23.txt";
        $this->assertEquals("149245887792", (new Day23())->question2($inputFile));
    }
}