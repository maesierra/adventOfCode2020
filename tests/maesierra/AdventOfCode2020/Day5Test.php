<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day5\Seat;
use PHPUnit\Framework\TestCase;

class Day5Test extends TestCase {

    public function testGetSeat() {
        $day5 = new Day5();
        $this->assertEquals(new Seat(44, 5, 357), $day5->getSeat('FBFBBFFRLR'));
        $this->assertEquals(new Seat(70, 7, 567), $day5->getSeat('BFFFBBFRRR'));
        $this->assertEquals(new Seat(14, 7, 119), $day5->getSeat('FFFBBBFRRR'));
        $this->assertEquals(new Seat(102, 4, 820), $day5->getSeat('BBFFBBFRLL'));

    }

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day5_1.txt";
        $this->assertEquals(820, (new Day5())->question1($inputFile));
    }
}