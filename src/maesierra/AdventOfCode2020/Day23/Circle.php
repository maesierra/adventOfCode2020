<?php


namespace maesierra\AdventOfCode2020\Day23;


class Circle {

    /** @var Node[] */
    public $nodes = [];
    /**
     * @var int
     */
    private $len;

    /**
     * @var Node
     */
    private $current;

    /**
     * @param $labels
     */
    public function __construct($labels) {
        $this->len = count($this->nodes);
        foreach ($labels as $pos => $label) {
            $node = new Node($label);
            $this->nodes[] = $node;
            if ($pos == 0) {
                continue;
            }
            $prev = $this->nodes[$pos - 1];
            $prev->link($node);
        }
        //Close the circle
        $first = reset($this->nodes);
        $last = end($this->nodes);
        $last->link($first);
        $this->current = $first;
        //Map nodes by label
        $this->nodes = array_reduce($this->nodes, function(&$res, $node) {
            /** @var Node $node */
            $res[$node->label] = $node;
            return $res;
        }, []);
    }

    /**
     * Extracts a number of items from the current position
     * @param int $n
     * @return Node[] indexed by label
     */
    public function pick(int $n): array {
        /** @var Node[] $picked */
        $picked = [];
        $node = $this->current->right;
        for ($i = 0; $i < $n; $i++) {
            $picked[$node->label] = $node;
            $node = $node->right;
        }
        //remove the nodes by connecting current to the right of the last removed
        $this->current->right = $node;
        return $picked;
    }

    public function current(): int {
        return $this->current->label;
    }

    /**
     * @param int $destination
     * @param Node[] $nodes
     */
    public function insert(int $destination, array $nodes) {
        $startNode = $this->nodes[$destination];
        $endNode = $startNode->right;
        $node = $startNode;
        foreach ($nodes as $n) {
            $node->link($n);
            $node = $n;
        }
        $node->link($endNode);
    }


    public function moveCurrentToNext() {
        $this->current = $this->current->right;
    }

    /**
     * @return int[]
     */
    public function getLabels():array {
        return array_keys($this->nodes);
    }

    public function __toString() {
        $start = $this->nodes[1];
        $node = $start->right;
        $labels = [$start->label];
        while ($node !== $start) {
            $labels[] = $node === $this->current ? "({$node->label})" : $node->label;
            $node = $node->right;
        }
        return implode(" ", $labels);
    }
}