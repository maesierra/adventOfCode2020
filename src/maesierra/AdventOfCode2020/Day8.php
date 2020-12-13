<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;




use maesierra\AdventOfCode2020\Day8\Acc;
use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Jmp;
use maesierra\AdventOfCode2020\Day8\Nop;
use maesierra\AdventOfCode2020\Day8\Runtime;

class Day8 {

    /**
     * @param $inputFile string
     * @return Instruction[]
     */
    private function parseInstructions(string $inputFile): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$result, $line) {
            if (preg_match('/^('.implode('|', [Acc::$ACC, Nop::$NOP, Jmp::$JMP]).') ([+-]\d+)$/', $line, $matches)) {
                switch ($matches[1]) {
                    case Acc::$ACC:
                        $result[] = new Acc($matches[2]);
                        break;
                    case Nop::$NOP:
                        $result[] = new Nop($matches[2]);
                        break;
                    case Jmp::$JMP:
                        $result[] = new Jmp($matches[2]);
                        break;
                }
            }
            return $result;
        }, []);
    }


    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile): int {
        $instructions = $this->parseInstructions($inputFile);
        return $this->createRuntime($instructions)->run()['acc'];
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $instructions = $this->parseInstructions($inputFile);
        //filter all the nop or jmp
        $candidates = array_filter($instructions, function($i) {
            return in_array($i->name, [Nop::$NOP, Jmp::$JMP]);
        });
        foreach ($candidates as $pos => $instruction) {
            $new = $instruction instanceof Nop ? new Jmp($instruction->value) : new Nop($instruction->value);
            echo "Attempt swapping $pos $instruction => $new\n";
            $newSet = $instructions;
            $newSet[$pos] = $new;
            $runtime = $this->createRuntime($newSet);
            $accumulator = $runtime->run()['acc'];
            if ($runtime->success) {
                return $accumulator;
            }
        }
        return 0;
    }

    /**
     * @param array $instructions
     * @return Runtime
     */
    public function createRuntime(array $instructions): Runtime
    {
        return (new Runtime($instructions, ['acc' => 0]));
    }
}