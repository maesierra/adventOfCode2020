<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;




use maesierra\AdventOfCode2020\Day7\Bag;

class Day7 {

    /**
     * @param $inputFile string
     * @return Bag[]
     */
    private function readBagDefinitions(string $inputFile): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$result, $line) {
            preg_match('/^(.+) bags contain (.*)\.$/', $line, $matches);
            $colour = $matches[1];
            if (!isset($result[$colour])) {
                $bag = new Bag($colour);
                $result[$colour] = $bag;
            } else {
                $bag = $result[$colour];
            }
            $containsPart = $matches[2];
            foreach (explode(',', $containsPart) as $contains) {
                if ($contains == 'no other bags') {
                    return $result;
                }
                preg_match('/(\d+) (.*?) bags?/', $contains, $matches);
                $containedColour = $matches[2];
                if (!isset($result[$containedColour])) {
                    $containedBag = new Bag($containedColour);
                    $result[$containedColour] = $containedBag;
                } else {
                    $containedBag = $result[$containedColour];
                }
                $bag->addAllowed($matches[1], $containedBag);
            }
            return $result;
        }, []);
    }


    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile): int {
        $allowed = array_filter($this->readBagDefinitions($inputFile), function($r) {
            return $r->canContain('shiny gold');
        });
        return count($allowed);
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $bags = $this->readBagDefinitions($inputFile);
        return $bags['shiny gold']->count();
    }
}