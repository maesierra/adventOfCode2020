<?php


namespace maesierra\AdventOfCode2020\Day8;


class Acc extends Instruction {

    public static $ACC = 'acc';
    /**
     * Acc constructor.
     */
    public function __construct($value) {
        parent::__construct(self::$ACC, $value);
    }


    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $runtime->variables['acc'] += $this->value;
    }
}