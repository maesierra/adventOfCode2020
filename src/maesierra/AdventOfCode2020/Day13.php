<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;






class Day13 {


    /**
     * Returns busID => wait time for the next available bus
     * @param $inputFile string The first line is your estimate of the earliest timestamp you could depart on a bus.
     * The second line lists the bus IDs that are in service according to the shuttle company; entries that show x must be out of service,
     * @return array
     */
    public function question1($inputFile): array {
        $lines = explode("\n", file_get_contents($inputFile));
        $timestamp = $lines[0];
        $ids = array_filter(explode(",", $lines[1]), function ($c) {
            return $c  != 'x';
        });
        sort($ids);
        $max = end($ids);
        for ($ts = $timestamp; $ts <= $timestamp + $max; $ts++) {
            foreach ($ids as $id) {
                if ($ts % $id == 0) {
                    return [$id => $ts - $timestamp];
                }
            }
        }
        return [];
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile, $start = 0) {
        $lines = explode("\n", file_get_contents($inputFile));
        $ids = explode(",", $lines[1]);
        if ($start) {
            return $this->search($ids, $start);
        }
        list($numbers, $remainders, $positions) = array_reduce(array_keys($ids), function (&$result, $pos) use($ids) {
            $c = $ids[$pos];
            if ($c  != 'x') {
                $result[0][] = (int) $c;
                $result[1][] = $pos == 0 ? 0 : $c - $pos;
                $result[2][$c] = $pos;
            }
            return $result;
        }, [[], [], []]);
        print_r($positions);
        print_r($numbers);
        print_r($remainders);
        return $this->crt($numbers, $remainders);
    }

    private function computeInverse(int $a, int $b):int {
        $x = 0;
        $y = 1;
        $m = $b;

        if ($b == 1) {
            return 0;
        }

        // Apply extended Euclid Algorithm
        while ($a > 1)
        {
            // q is quotient
            $q = (int) ($a / $b);
            $t = $b;

            // m is remainder now, process
            // same as euclid's algo
            $b = $a % $b;
            $a = $t;

            $t = $x;

            $x = $y - $q * $x;

            $y = $t;
        }
        // Make x1 positive
        if ($y < 0) {
            $y += $m;
        }
        return $y;

    }

    public function crt($numbers, $remainders) {
        $product = array_reduce($numbers, function($res, $n) {
            return $n * $res;
        }, 1);
        $sum = array_reduce(array_keys($numbers), function($res, $i) use ($product, $numbers, $remainders) {
            $n = $numbers[$i];
            $remainder = $remainders[$i];
            $partialProduct = (int) ($product / $n);
            $inverse = $this->computeInverse($partialProduct, $n);
            return $res + ($partialProduct * $inverse * $remainder);
        }, 0);
        return $sum % $product;
    }

    /**
     * @param array $ids
     * @param int $start
     * @return int
     */
    public function search(array $ids, int $start = 0)
    {
        $max = max(array_filter($ids, function ($n) {
            return $n != 'x';
        }));
        $step = $max;
        $nSteps = $start ? (int)($start / $max) : 1;
        $ts = ($step * $nSteps) - array_search($max, $ids) - $step;
        $attempts = 0;
        do {
            $ts += $step;
            $found = true;
            echo "$attempts Testing $ts\n";
            foreach ($ids as $pos => $id) {
                if ($id != 'x') {
                    if (($ts + $pos) % $id != 0) {
                        echo "Stopped at $id\n";
                        $found = false;
                        break;
                    }
                }
            }
            $attempts++;
        } while (!$found);
        return $ts;
    }
}