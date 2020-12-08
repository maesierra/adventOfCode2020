<?php


namespace maesierra\AdventOfCode2020\Day8;


class Nop extends Instruction {

    public static $NOP = 'nop';
    /**
     * Acc constructor.
     */
    public function __construct($value) {
        parent::__construct(self::$NOP, $value);
    }


}