<?php


namespace maesierra\AdventOfCode2020\Day8;


class Jmp extends Instruction {

    public static $JMP = 'jmp';
    /**
     * Acc constructor.
     */
    public function __construct($value) {
        parent::__construct(self::$JMP, $value);
    }
    /**
     * @inheritDoc
     */
    public function next(Runtime $runtime):int {
        return $runtime->current + $this->value;
    }
}