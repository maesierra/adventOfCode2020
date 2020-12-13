<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

abstract class RotateAround extends Instruction {

    public $object;

    /**
     * Rotate constructor.
     * @param $object
     */
    public function __construct($name, $object, $value) {
        parent::__construct($name, $value);
        $this->object = $object;
    }


    public abstract function rotationMatrix():array;

    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $steps = (int) $this->value / 90;
        $matrix = $this->rotationMatrix();
        $object = $runtime->variables[$this->object];
        for ($i = 0; $i< $steps; $i++) {
            $long = $object['long'] * $matrix[0][0] + $object['lat'] * $matrix[0][1];
            $lat = $object['long'] * $matrix[1][0] + $object['lat'] * $matrix[1][1];
            $object['long'] = $long;
            $object['lat'] = $lat;
        }
        $runtime->variables[$this->object]['lat'] = $object['lat'];
        $runtime->variables[$this->object]['long'] = $object['long'];
    }
}