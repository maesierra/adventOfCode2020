<?php


namespace maesierra\AdventOfCode2020\Day8;


abstract class Instruction {

    /** @var string */
    public $name;

    public $value;

    public $count;

    /**
     * Instruction constructor.
     * @param string|int $name
     * @param $value
     */
    public function __construct(string $name, $value) {
        $this->name = $name;
        $this->value = $value;
        $this->count = 0;
    }

    /**
     * @param Runtime $runtime
     * @return void
     */
    public function run(Runtime $runtime) {

    }

    public function next(Runtime $runtime): int {
        return $runtime->current + 1;
    }

    public function __toString() {
        return "{$this->name} {$this->value}";
    }

}