<?php


namespace maesierra\AdventOfCode2020\Day8;


class Runtime {

    public $accumulator = 0;
    /** @var Instruction[] */
    public  $instructions;
    public  $current = 0;
    public $success = false;

    /**
     * Runtime constructor.
     * @param Instruction[] $instructions
     */
    public function __construct(array $instructions) {
        $this->instructions = $instructions;
        foreach ($this->instructions as $instruction) {
            $instruction->count = 0;
        }
    }

    public function run():int {
        while ($this->current < count($this->instructions)) {
            $instruction = $this->instructions[$this->current];
            if ($instruction->count > 0) {
                //Infinite loop detected
                return $this->accumulator;
            }
            $instruction->run($this);
            $this->current = $instruction->next($this);
            $instruction->count++;
        }
        $this->success = true;
        return $this->accumulator;
    }

}