<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



class Day6 {

    /**
     * Reads all the answers in a group. A group is separated by 2 black lines
     * @param $inputFile
     * @return array[] array with all the groups. For each group an map with answer => occurrences
     */
    private function readAnswers($inputFile) {
        $groups = array_reduce(explode("\n", file_get_contents($inputFile)),
            function (&$result, $line) {
                if (!$result && $line) {
                    $result[] = $line;
                    return $result;
                }
                if ($line == '') {
                    $result[] = '';
                } else {
                    $last = count($result) - 1;
                    $result[$last] = "{$result[$last]}\n$line";
                }
                return $result;
            }, []);
        return array_reduce($groups, function (&$result, $text) {
            $result[trim($text)] = array_filter(count_chars($text, 1), function ($c) {
                return $c >= ord('a') && $c<= ord('z');
            }, ARRAY_FILTER_USE_KEY);
            return $result;
        }, []);
    }

    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile) {
        $answers = $this->readAnswers($inputFile);
        return array_sum(array_map(function($answers) {
            return count($answers);
        }, $answers));
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $answers = $this->readAnswers($inputFile);
        return array_sum(array_map(function($group, $answers) {
            $groupSize = substr_count($group, "\n") + 1;
            $allYes = array_filter($answers, function ($n) use ($groupSize) {
                return $n == $groupSize;
            });
            return count($allYes);
        }, array_keys($answers), array_values($answers)));
    }
}