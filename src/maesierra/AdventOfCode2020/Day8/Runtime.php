<?php


namespace maesierra\AdventOfCode2020\Day8;


class Runtime {

    /** @var array */
    public $variables = 0;
    /** @var Instruction[] */
    public  $instructions;
    public  $current = 0;
    public $success = false;

    /**
     * Runtime constructor.
     * @param Instruction[] $instructions
     */
    public function __construct(array $instructions, array $variables) {
        $this->instructions = $instructions;
        $this->variables = $variables;
        foreach ($this->instructions as $instruction) {
            $instruction->count = 0;
        }
    }

    public function run():array {
        while ($this->current < count($this->instructions)) {
            $instruction = $this->instructions[$this->current];
            if ($instruction->count > 0) {
                //Infinite loop detected
                return $this->variables;
            }
            $instruction->run($this);
            echo "{$instruction} => ".json_encode($this->variables)."\n";
            $this->current = $instruction->next($this);
            $instruction->count++;
        }
        $this->success = true;
        return $this->variables;
    }

}