<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day19Test extends TestCase {

    public function testQuestion1() {
        $this->assertEquals(2, (new Day19())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day19.txt"));
        $this->assertEquals(4, (new Day19())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day19_1.txt"));
        $this->assertEquals(3, (new Day19())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day19_2.txt"));
    }

    public function testQuestion2() {
        $this->assertEquals(12, (new Day19())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day19_2.txt"));
    }
}