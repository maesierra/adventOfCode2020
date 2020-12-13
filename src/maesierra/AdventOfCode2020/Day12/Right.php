<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Right extends Rotate {

    public static $RIGHT = 'R';

    public function __construct($value, $object) {
        parent::__construct(self::$RIGHT, $object, $value);
    }

    protected function rotation():array {
        return  [
            CardinalDirections::$NORTH => CardinalDirections::$EAST,
            CardinalDirections::$WEST => CardinalDirections::$NORTH,
            CardinalDirections::$SOUTH => CardinalDirections::$WEST,
            CardinalDirections::$EAST => CardinalDirections::$SOUTH,
        ];
    }

}