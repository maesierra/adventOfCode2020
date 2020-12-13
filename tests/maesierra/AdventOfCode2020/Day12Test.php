<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day12Test extends TestCase {


    public function testQuestion1() {
        $this->assertEquals(25, (new Day12())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day12.txt"));
    }

    public function testQuestion2() {
        $this->assertEquals(286, (new Day12())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day12.txt"));
    }
}