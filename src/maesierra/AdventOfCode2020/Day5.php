<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



use maesierra\AdventOfCode2020\Day5\Seat;

class Day5 {

    /**
     * @param $code array containing the codes for each position
     * @param $range int[]
     * @param $isLowerPredicate \Closure that will take the value. It should return true if the value should
     * be assigned to the lower range
     * @return int
     */
    private function decode($code, $range, \Closure $isLowerPredicate) {
        $res = array_reduce($code, function ($result, $c) use ($isLowerPredicate) {
            list($lower, $upper) = $result;
            $half = (int)(($upper - $lower) / 2);
            if ($isLowerPredicate($c)) {
                return [$lower, $lower + $half];
            } else {
                return [$lower + $half + 1, $upper];
            }
        }, $range);
        return $res[0];
    }

    /**
     * Decodes the seat from the given code
     * The first 7 characters will either be F or B; these specify exactly one of the 128 rows on the plane (numbered 0 through 127). Each letter tells you which half of a region the given seat is in. Start with the whole list of rows; the first letter indicates whether the seat is in the front (0 through 63) or the back (64 through 127). The next letter indicates which half of that region the seat is in, and so on until you're left with exactly one row.
     *
     * For example, consider just the first seven characters of FBFBBFFRLR:
     *
     * Start by considering the whole range, rows 0 through 127.
     * F means to take the lower half, keeping rows 0 through 63.
     * B means to take the upper half, keeping rows 32 through 63.
     * F means to take the lower half, keeping rows 32 through 47.
     * B means to take the upper half, keeping rows 40 through 47.
     * B keeps rows 44 through 47.
     * F keeps rows 44 through 45.
     * The final F keeps the lower of the two, row 44.
     *
     * The last three characters will be either L or R; these specify exactly one of the 8 columns of seats on the plane (numbered 0 through 7). The same process as above proceeds again, this time with only three steps. L means to keep the lower half, while R means to keep the upper half.
     *
     * For example, consider just the last 3 characters of FBFBBFFRLR:
     *
     * Start by considering the whole range, columns 0 through 7.
     * R means to take the upper half, keeping columns 4 through 7.
     * L means to take the lower half, keeping columns 4 through 5.
     * The final R keeps the upper of the two, column 5.
     *
     * So, decoding FBFBBFFRLR reveals that it is the seat at row 44, column 5.
     *
     * Every seat also has a unique seat ID: multiply the row by 8, then add the column. In this example, the seat has ID 44 * 8 + 5 = 357.
     *
     * @param string $code
     * @return Seat
     */
    public function getSeat(string $code) {
        $code = str_split($code);
        $row = $this->decode(array_slice($code, 0, 7), [0, 127], function($c) {
            return $c == 'F';
        });
        $column = $this->decode(array_slice($code, 7), [0, 7], function($c) {
            return $c == 'L';
        });
        return new Seat($row, $column);
    }

    /**
     * Reads all the boarding passes in the given file
     * @param $inputFile
     * @return Seat[]
     */
    private function readBoardingPasses($inputFile) {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$result, $code) {
            $seat = $this->getSeat($code);
            $result[$seat->id] = $seat;
            return $result;
        }, []);
    }

    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile) {
        return array_reduce($this->readBoardingPasses($inputFile), function($res, $seat) {
            /** @var $seat Seat */
            return $seat->id > $res ? $seat->id : $res;
        }, 0);
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $plane = [];
        for ($i = 0; $i < 128; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $seat = new Seat($i, $j);
                $plane[$seat->id] = $seat;
            }
        }
        $scanned = $this->readBoardingPasses($inputFile);
        ksort($scanned);
        /** @var Seat[] $matching */
        $matching = array_intersect_key($plane, $scanned);
        $firstRow = reset($matching)->row;
        $lastRow = end($matching)->row;
        /** @var Seat[] $missing */
        $missing = array_diff_key($plane, $scanned);
        $missing = array_filter($missing, function($seat) use($firstRow, $lastRow) {
            return $seat->row > $firstRow && $seat->row < $lastRow;
        });
        return reset($missing)->id;
    }
}