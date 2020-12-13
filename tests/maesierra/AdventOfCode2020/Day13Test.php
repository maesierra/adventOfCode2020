<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day13Test extends TestCase {


    public function testQuestion1() {
        $res = (new Day13())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day13.txt");
        $this->assertEquals(295, array_keys($res)[0] * array_values($res)[0]);
    }

    public function testCrt() {
        $this->assertEquals(1068781, (new Day13())->crt([7,13,59,31,19], [0,12,55,25,12]));
    }

    public function testQuestion2() {
        $this->assertEquals(1068781, (new Day13())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day13.txt"));
    }
}