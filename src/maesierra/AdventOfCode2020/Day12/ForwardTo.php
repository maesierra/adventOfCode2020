<?php


namespace maesierra\AdventOfCode2020\Day12;


use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;

class ForwardTo extends Instruction {

    public static $FORWARD_TO = 'F';

    public $srcObject;
    public $destObject;

    public function __construct($value, $srcObject, $destObject) {
        parent::__construct(self::$FORWARD_TO, $value);
        $this->srcObject = $srcObject;
        $this->destObject = $destObject;
    }

    /**
     * @param $src array
     * @return Instruction[]
     */
    private function toInstructions(array $src):array {
        $instructions = [];
        $long = $src[Move::$LONG];
        $lat = $src[Move::$LAT];
        if ($lat > 0) {
            $instructions[] = new North($lat * $this->value, $this->destObject);
        } else if ($lat < 0) {
            $instructions[] = new South($lat * $this->value * -1, $this->destObject);
        }
        if ($long < 0) {
            $instructions[] = new West($long * $this->value * -1, $this->destObject);
        } else if ($long > 0) {
            $instructions[] = new East($long * $this->value, $this->destObject);
        }
        return $instructions;
    }

    /**
     * @inheritDoc
     */
    public function run(Runtime $runtime) {
        $instructions = $this->toInstructions($runtime->variables[$this->srcObject]);
        foreach ($instructions as $instruction) {
            $instruction->run($runtime);
        }
    }
}