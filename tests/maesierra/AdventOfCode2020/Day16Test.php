<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day16Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day16.txt";
        $this->assertEquals(71, (new Day16())->question1($inputFile));
    }

    public function testGetTicket() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day16_2.txt";
        $this->assertEquals([
            "class" =>  12,
            "row" => 11,
            "seat" => 13

        ], (new Day16())->getTicket($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day16_3.txt";
        $this->assertEquals(156, (new Day16())->question2($inputFile));
    }
}