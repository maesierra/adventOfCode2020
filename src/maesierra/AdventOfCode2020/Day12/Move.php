<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Move extends Instruction {

    public static $LONG = 'long';
    public static $LAT = 'lat';

    public $object;
    public $property;

    /**
     * Move constructor.
     */
    public function __construct($name, $object, $property, $value) {
        parent::__construct($name, $value);
        $this->object = $object;
        $this->property = $property;
    }

    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $runtime->variables[$this->object][$this->property] += $this->value;
    }

    public function __toString() {
        return "{$this->name} ".abs($this->value);
    }

}