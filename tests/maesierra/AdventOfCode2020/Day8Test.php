<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day8Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day8.txt";
        $this->assertEquals(5, (new Day8())->question1($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day8.txt";
        $this->assertEquals(8, (new Day8())->question2($inputFile));
    }
}