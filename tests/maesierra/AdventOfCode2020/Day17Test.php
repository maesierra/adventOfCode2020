<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day17Test extends TestCase {

    public function testNext3d() {
        $day17 = new Day17();
        $state0 = [
            0 => [
                str_split('.#.'),
                str_split('..#'),
                str_split('###'),
            ]
        ];

        $state1 = $day17->next3d($state0);
        $this->assertEquals(11, $day17->countActive3d($state1));
        $state2 = $day17->next3d($state1);
        $this->assertEquals(21, $day17->countActive3d($state2));
        $state3 = $day17->next3d($state2);
        $this->assertEquals(38, $day17->countActive3d($state3));
    }

    public function testNext4d() {
        $day17 = new Day17();
        $state0 = [
            0 => [
                0 => [
                    str_split('.#.'),
                    str_split('..#'),
                    str_split('###'),
                ]
            ]
        ];

        $state1 = $day17->next4d($state0);
        $this->assertEquals(29, $day17->countActive4d($state1));
    }

    public function testQuestion1() {
        $this->assertEquals(112, (new Day17())->question1(__DIR__ . DIRECTORY_SEPARATOR . "Day17.txt"));
    }

    public function testQuestion2() {
        $this->assertEquals(848, (new Day17())->question2(__DIR__ . DIRECTORY_SEPARATOR . "Day17.txt"));
    }

}