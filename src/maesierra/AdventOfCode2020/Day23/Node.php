<?php


namespace maesierra\AdventOfCode2020\Day23;


class Node {
    /** @var int */
    public $label;

    /** @var Node */
    public $right;

    /**
     * Link constructor.
     * @param $label
     */
    public function __construct($label) {
        $this->label = $label;
    }

    /**
     * Links a node to the rights side making the bidirectional connection
     * @param $node Node
     */
    public function link(Node $node) {
        $this->right = $node;
    }

}