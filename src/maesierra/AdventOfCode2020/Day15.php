<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;





class Day15 {

    /** @var int[] */
    private $numbers;

    private $started = false;

    /** @var int  */
    private $pos = 0;
    /** @var array int[] */
    private $spoken = [];
    /** @var int */
    private $last;

    /**
     * Day15 constructor.
     * @param int[] $numbers
     */
    public function __construct(array $numbers) {
        $this->numbers = $numbers;
        $this->reset();
    }

    private function reset() {
        $this->spoken = [];
        $this->pos = 0;
        $this->last = null;
        $this->started = false;
    }



    /**
     * Returns the next sequence number according to the "Rambunctious Recitation"
     * @return int
     */
    public function next():int {
        if (!$this->started) {
            $next = $this->numbers[$this->pos];
            $this->started = $this->pos >= (count($this->numbers) - 1);
        } else {
            $lastSpoken = $this->spoken[$this->last] ?? [];
            switch (count($lastSpoken)) {
                case 0:
                case 1:
                    $next = (int) 0;
                    break;
                default:
                    $next = $lastSpoken[0] - $lastSpoken[1];
            }
        }
        if (isset($this->spoken[$next])) {
            $this->spoken[$next] = [
                $this->pos,
                $this->spoken[$next][0]
            ];
        } else {
            $this->spoken[$next] = [$this->pos];
        }
        $this->pos++;
        $this->last = $next;
        return $next;
    }

    /**
     * Returns the nth sequence number according to the "Rambunctious Recitation"
     * https://adventofcode.com/2020/day/15
     * @param int $position
     * @return int
     */
    public function nThPosition(int $position): int
    {
        $this->reset();
        for ($i = 0; $i < $position; $i++) {
            $this->next();
            echo "$i => {$this->last}\n";
        }
        return $this->last;
    }
}