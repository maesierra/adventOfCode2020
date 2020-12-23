<?php


namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day23\Circle;

class Day23 {


    public function question1(string $inputFile, int $moves):string {
        $labels = str_split(trim(file_get_contents($inputFile)));
        $circle = new Circle($labels);
        $this->runGame($circle, $moves);
        return preg_replace("/[ 1()]/", "", "$circle");
    }

    public function question2(string $inputFile):string {
        $labels = str_split(trim(file_get_contents($inputFile)));
        $labels = array_merge($labels, range(max($labels) + 1, 1000000));
        $circle = new Circle($labels);
        $this->runGame($circle, 10000000, false);
        $node1 = $circle->nodes[1]->right;
        $node2 = $node1->right;
        return $node1->label * $node2->label;
    }

    /**
     * @param Circle $circle
     * @param int $moves
     * @param bool $verbose
     */
    public function runGame(Circle $circle, int $moves, bool $verbose = true): void {
        $max = max($circle->getLabels());
        $min = min($circle->getLabels());
        for ($i = 1; $i <= $moves; $i++) {
            echo("-- move $i --\n");
            if ($verbose) {
                echo("cups: {$circle}\n");
            }
            $picked = $circle->pick(3);
            $pickedLabels = array_keys($picked);
            $destination = $circle->current();
            do {
                $destination = $destination - 1 < $min ? $max : $destination - 1;
            } while (in_array($destination, $pickedLabels));

            $circle->insert($destination, $picked);
            $circle->moveCurrentToNext();
        }
    }

}