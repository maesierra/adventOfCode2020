<?php


namespace maesierra\AdventOfCode2020\Day14;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Mask extends Instruction {

    public static $MASK = 'mask';

    public function __construct($value) {
        parent::__construct(self::$MASK, $value);
    }

    public function run(Runtime $runtime) {
        $runtime->variables['mask'] = str_split($this->value);
    }
}