<?php


namespace maesierra\AdventOfCode2020\Day10;


class Node {
    /** @var Node[] */
    public $next;
    public $parent;
    public $value;

    /**
     * Node constructor.
     * @param $value
     * @param $parent Node
     */
    public function __construct($value, $parent) {
        $this->value = $value;
        $this->parent = $parent;
    }
}
