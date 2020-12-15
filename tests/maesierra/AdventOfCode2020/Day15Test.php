<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day15Test extends TestCase {

    public function testNext() {
        $day15 = new Day15([0,3,6]);
        $this->assertEquals(0, $day15->next()); #1
        $this->assertEquals(3, $day15->next()); #2
        $this->assertEquals(6, $day15->next()); #3
        $this->assertEquals(0, $day15->next()); #4
        $this->assertEquals(3, $day15->next()); #5
        $this->assertEquals(3, $day15->next()); #6
        $this->assertEquals(1, $day15->next()); #7
        $this->assertEquals(0, $day15->next()); #8
        $this->assertEquals(4, $day15->next()); #9
        $this->assertEquals(0, $day15->next()); #10
    }

    public function testNthPosition() {
        $this->assertEquals(436, (new Day15([0,3,6]))->nThPosition(2020));
        $this->assertEquals(1,   (new Day15([1,3,2]))->nThPosition(2020));
        $this->assertEquals(27,  (new Day15([1,2,3]))->nThPosition(2020));
        $this->assertEquals(78,  (new Day15([2,3,1]))->nThPosition(2020));
        $this->assertEquals(438, (new Day15([3,2,1]))->nThPosition(2020));
        $this->assertEquals(1836,(new Day15([3,1,2]))->nThPosition(2020));
    }

    public function testNthPosition_big() {
        $this->assertEquals(175594, (new Day15([0,3,6]))->nThPosition(30000000));
    }
}