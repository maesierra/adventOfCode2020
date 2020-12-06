<?php

namespace maesierra\AdventOfCode2020\Day3;

class Position
{
    public $x;
    public $y;
    public $trees;
    public $block;

    /**
     * Position constructor.
     * @param $x
     * @param $y
     * @param $block
     * @param $trees
     */
    public function __construct($x = 0, $y = 0, $block = 0, $trees = 0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->block = $block;
        $this->trees = $trees;
    }

    public function __toString()
    {
        return "block {$this->block} {$this->x} {$this->y}";
    }

}