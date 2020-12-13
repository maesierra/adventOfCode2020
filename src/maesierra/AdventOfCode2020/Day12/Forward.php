<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Forward extends Instruction {

    public static $FORWARD = 'F';

    public $object;

    public function __construct($value, $object) {
        parent::__construct(self::$FORWARD, $value);
        $this->object = $object;
    }

    private function directionToInstruction($direction, $value) {
        switch ($direction) {
            case CardinalDirections::$NORTH:
                return new North($value, $this->object);
            case CardinalDirections::$SOUTH:
                return new South($value, $this->object);
            case CardinalDirections::$EAST:
                return new East($value, $this->object);
            case CardinalDirections::$WEST:
                return new West($value, $this->object);
        }
    }

    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $this->directionToInstruction($runtime->variables[$this->object]['direction'], $this->value)->run($runtime);
    }
}