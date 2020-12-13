<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class RotateCounterClockwise extends RotateAround {

    public static $ROTATE_COUNTERCLOCKWISE = 'L';

    public function __construct($value, $object) {
        parent::__construct(self::$ROTATE_COUNTERCLOCKWISE, $object, $value);
    }

    public function rotationMatrix(): array {
        return [
            [0, -1],
            [1, 0]
        ];
    }


}