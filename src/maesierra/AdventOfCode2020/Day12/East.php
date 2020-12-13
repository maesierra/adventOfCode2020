<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class East extends Move {

    public static $EAST = 'E';

    public function __construct($value, $object) {
        parent::__construct(self::$EAST, $object, Move::$LONG, $value);
    }

}