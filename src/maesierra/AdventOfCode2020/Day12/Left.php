<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Left extends Rotate {

    public static $LEFT = 'L';

    public function __construct($value, $object) {
        parent::__construct(self::$LEFT, $object, $value);
    }

    protected function rotation():array {
        return  [
            CardinalDirections::$NORTH => CardinalDirections::$WEST,
            CardinalDirections::$EAST => CardinalDirections::$NORTH,
            CardinalDirections::$SOUTH => CardinalDirections::$EAST,
            CardinalDirections::$WEST => CardinalDirections::$SOUTH,
        ];
    }

}