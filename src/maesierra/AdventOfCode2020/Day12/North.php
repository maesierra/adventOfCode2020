<?php


namespace maesierra\AdventOfCode2020\Day12;


class North extends Move {

    public static $NORTH = 'N';

    public function __construct($value, $object) {
        parent::__construct(self::$NORTH, $object, Move::$LAT, $value);
    }

}