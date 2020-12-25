<?php


namespace maesierra\AdventOfCode2020;


class Day25 {

    public function transform($subject, $value): int {
        return ($value * $subject) % 20201227;
    }

    public function calculateLoopSize($subject, $pk): int {
        $loopSize = 0;
        $value = 1;
        while ($pk != $value) {
            $loopSize++;
            echo "LoopSize attempt #$loopSize\n";
            $value = $this->transform($subject, $value);
        }
        return $loopSize;
    }

    public function question1(string $inputFile): int {
        list($cardPK, $doorPK) = explode("\n", file_get_contents($inputFile));
        $doorLoopSize = $this->calculateLoopSize(7, $doorPK);
        $value = 1;
        for ($i = 0; $i < $doorLoopSize; $i++) {
            $value = $this->transform($cardPK, $value);
        }
        return $value;
    }
}