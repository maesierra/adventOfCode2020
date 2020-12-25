<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use PHPUnit\Framework\TestCase;

class Day25Test extends TestCase {

    public function testCalculateLoopSize() {
        $day25 = new Day25();
        $this->assertEquals(8, $day25->calculateLoopSize(7, 5764801));
        $this->assertEquals(11, $day25->calculateLoopSize(7, 17807724));
    }

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day25.txt";
        $this->assertEquals(14897079, (new Day25())->question1($inputFile));
    }

}