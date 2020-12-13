<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

abstract class Rotate extends Instruction {

    public $object;

    /**
     * Rotate constructor.
     * @param $object
     */
    public function __construct($name, $object, $value) {
        parent::__construct($name, $value);
        $this->object = $object;
    }


    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $steps = (int) $this->value / 90;
        $rotation = $this->rotation();
        for ($i = 0; $i< $steps; $i++) {
            $runtime->variables[$this->object]['direction'] = $rotation[$runtime->variables[$this->object]['direction']];
        }
    }
}