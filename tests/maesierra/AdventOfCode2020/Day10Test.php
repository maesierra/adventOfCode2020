<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day10Test extends TestCase {

    public function testCalculateDistribution() {
        $day10 = new Day10();
        $this->assertEquals([1 => 7, 2 => 0,  3 => 5], $day10->calculateDistribution( __DIR__ . DIRECTORY_SEPARATOR . "Day10_1.txt"));
        $this->assertEquals([1 => 22, 2 => 0,  3 => 10], $day10->calculateDistribution( __DIR__ . DIRECTORY_SEPARATOR . "Day10_2.txt"));
    }

    public function testQuestion1() {
        $this->assertEquals(35, (new Day10())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day10_1.txt"));
        $this->assertEquals(220, (new Day10())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day10_2.txt"));
    }

    public function testQuestion2() {
        $this->assertEquals(49, (new Day10())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day10_3.txt"));
        $this->assertEquals(19208, (new Day10())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day10_2.txt"));
        $this->assertEquals(8, (new Day10())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day10_1.txt"));
    }
}