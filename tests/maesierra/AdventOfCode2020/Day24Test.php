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
        $day24 = new Day24();
        $this->assertEquals(15, $day24->question2($inputFile, 1));
        $this->assertEquals(12, $day24->question2($inputFile, 2));
        $this->assertEquals(25, $day24->question2($inputFile, 3));
        $this->assertEquals(14, $day24->question2($inputFile, 4));
        $this->assertEquals(259, $day24->question2($inputFile, 30));
        $this->assertEquals(406, $day24->question2($inputFile, 40));
        $this->assertEquals(1373, $day24->question2($inputFile, 80));
        $this->assertEquals(1844, $day24->question2($inputFile, 90));
        $this->assertEquals(2208, $day24->question2($inputFile, 100));
    }
}