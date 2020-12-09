<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;




class Day9 {


    /**
     * Validates if the given number its the sum of any two numbers in the range.
     * @param array $range
     * @param int $number
     */
    public function validate(array $range, int $number) {
        //Convert to associative array for fast access
        $range = array_combine($range, $range);
        foreach ($range as $n) {
            $diff = $number - $n;
            if ($diff != $n && isset($range[$diff])) {
                return true;
            }
        }
        return false;
    }



    /**
     * Returns the first invalid number in the sequence
     * @param $inputFile
     * @param $size
     * @return int
     */
    public function question1($inputFile, $size): int {
        $numbers = explode("\n", file_get_contents($inputFile));
        $preamble = array_slice($numbers, 0, $size);
        $current = $size;
        $len = count($numbers);
        while ($current < $len) {
            $n = $numbers[$current];
            if (!$this->validate($preamble, $n)) {
                return $n;
            }
            $preamble = array_merge(array_slice($preamble, 1), [$n]);
            $current++;
        }
        return 0;
    }

    /**
     * @param string $inputFile
     * @param int $number
     * @return int
     */
    public function question2(string $inputFile, int $number):int {
        $numbers = explode("\n", file_get_contents($inputFile));
        $current = 0;
        $len = count($numbers);
        while ($current < $len - 1) {
            $block = array_slice($numbers, $current, 2);
            $next = $current + 2;
            while (array_sum($block) < $number) {
                echo "Testing [$current - $next]\n";
                $block[] = $numbers[$next];
                $next++;
            }
            if (array_sum($block) == $number) {
                echo "Found [".join(',', $block)."]\n";
                sort($block);
                return reset($block) + end($block);
            }
            $current ++;
        }
        return 0;
    }
}