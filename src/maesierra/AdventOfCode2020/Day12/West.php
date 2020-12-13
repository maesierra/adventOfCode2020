<?php


namespace maesierra\AdventOfCode2020\Day12;


class West extends Move {

    public static $WEST = 'W';

    public function __construct($value, $object) {
        parent::__construct(self::$WEST, $object, Move::$LONG, $value * -1);
    }

}