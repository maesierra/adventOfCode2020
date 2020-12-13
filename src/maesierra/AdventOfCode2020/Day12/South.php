<?php


namespace maesierra\AdventOfCode2020\Day12;


class South extends Move {

    public static $SOUTH = 'S';

    public function __construct($value, $object) {
        parent::__construct(self::$SOUTH, $object, Move::$LAT, $value * -1);
    }
}