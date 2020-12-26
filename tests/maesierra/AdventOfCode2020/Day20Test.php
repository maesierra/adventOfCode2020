<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:43
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day20\Connection;
use PHPUnit\Framework\TestCase;

class Day20Test extends TestCase {

    public function testQuestion1() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day20.txt";
        $this->assertEquals(20899048083289, (new Day20())->question1($inputFile));
    }

    public function testQuestion2() {
        $inputFile = __DIR__ . DIRECTORY_SEPARATOR . "Day20.txt";
        $this->assertEquals(273, (new Day20())->question2($inputFile));
    }

    public function testRotate() {
        $image = [
            ['#', '.', '#', '#'],
            ['.', '.', '#', '.'],
            ['.', '#', '#', '#'],
            ['#', '#', '#', '#'],
        ];

        $this->assertEquals(
            [
                ['#', '#', '.', '#'],
                ['.', '#', '.', '.'],
                ['#', '#', '#', '.'],
                ['#', '#', '#', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_FLIP_X)
        );
        $this->assertEquals(
            [
                ['#', '#', '#', '#'],
                ['.', '#', '#', '#'],
                ['.', '.', '#', '.'],
                ['#', '.', '#', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_FLIP_Y)
        );

        $this->assertEquals(
            [
                ['#', '.', '.', '#'],
                ['#', '#', '.', '.'],
                ['#', '#', '#', '#'],
                ['#', '#', '.', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_ROTATED90)
        );
        $this->assertEquals(
            [
                ['#', '#', '#', '#'],
                ['#', '#', '#', '.'],
                ['.', '#', '.', '.'],
                ['#', '#', '.', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_ROTATED180)
        );

        $this->assertEquals(
            [
                ['#', '.', '#', '#'],
                ['#', '#', '#', '#'],
                ['.', '.', '#', '#'],
                ['#', '.', '.', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_ROTATED270)
        );


        $this->assertEquals(
            [
                ['#', '.', '.', '#'],
                ['.', '.', '#', '#'],
                ['#', '#', '#', '#'],
                ['#', '.', '#', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_ROTATED90_FLIP_X)
        );

        $this->assertEquals(
            [
                ['#', '#', '.', '#'],
                ['#', '#', '#', '#'],
                ['#', '#', '.', '.'],
                ['#', '.', '.', '#'],
            ],
            Day20::rotate($image, Connection::CONNECTION_ROTATED90_FLIP_Y)
        );




    }
}