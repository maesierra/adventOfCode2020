<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


class Day1 {


    private function validateEntry($entry) {
        return is_numeric($entry);
    }

    private function searchEntries($entries, $total, $start = 0) {
        $n = count($entries);
        for ($i = $start; $i < $n; $i++) {
            if (!$this->validateEntry($entries[$i])) {
                continue;
            }
            for ($j = $i + 1; $j < $n; $j++) {
                if (!$this->validateEntry($entries[$j])) {
                    continue;
                }
                if ($entries[$i] + $entries[$j] == $total) {
                    return [$entries[$i], $entries[$j]];
                }
            }
        }
        return [];
    }

    /**
     * Specifically, they need you to find the two entries that sum to 2020 and then multiply those two numbers together
     *
     * @param $inputFile string file containing a number per line
     * @return int two entries that sum to 2020 and then multiply those two numbers together
     * @throws \Exception
     */
    public function question1($inputFile) {
        $numbers = $this->searchEntries(explode("\n", file_get_contents($inputFile)), 2020);
        if ($numbers) {
            return $numbers[0] * $numbers[1];
        } else {
            throw new \Exception("Not found");
        }
    }

    public function question2(string $inputFile) {
        $entries = explode("\n", file_get_contents($inputFile));
        foreach ($entries as $i => $entry) {
            if (!$this->validateEntry($entry)) {
                continue;
            }
            $numbers = $this->searchEntries($entries, 2020 - $entry, $i + 1);
            if ($numbers) {
                return $numbers[0] * $numbers[1] * $entry;
            }
        }
        throw new \Exception("Not found");
    }
}