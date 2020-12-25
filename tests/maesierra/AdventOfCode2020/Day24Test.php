<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day24\Tile;
use PHPUnit\Framework\TestCase;

class Day24Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day24.txt";
        $this->assertEquals(10, (new Day24())->question1($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day24.txt";
        $this->assertEquals("mxmxvkd,sqjhc,fvjkl", (new Day24())->question2($inputFile));
    }
}