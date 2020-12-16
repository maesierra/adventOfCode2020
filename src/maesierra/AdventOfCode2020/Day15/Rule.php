<?php


namespace maesierra\AdventOfCode2020\Day15;


class Rule {

    /** @var string */
    public $name;
    /** @var int[][] */
    public $ranges;

    /**
     * Rule constructor.
     * @param $name
     * @param $ranges array
     */
    public function __construct(string $name, array $ranges) {
        $this->name = $name;
        $this->ranges = $ranges;
    }

    public function validate($number) {
        return array_reduce($this->ranges, function($res, $range) use($number) {
            $valid = $number >= $range[0] && $number <= $range[1];
            return $res || $valid;
        }, false);
    }

}