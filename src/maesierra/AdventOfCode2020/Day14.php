<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;





use maesierra\AdventOfCode2020\Day12\East;
use maesierra\AdventOfCode2020\Day12\Forward;
use maesierra\AdventOfCode2020\Day12\ForwardTo;
use maesierra\AdventOfCode2020\Day12\Left;
use maesierra\AdventOfCode2020\Day12\North;
use maesierra\AdventOfCode2020\Day12\Right;
use maesierra\AdventOfCode2020\Day12\RotateClockwise;
use maesierra\AdventOfCode2020\Day12\RotateCounterClockwise;
use maesierra\AdventOfCode2020\Day12\South;
use maesierra\AdventOfCode2020\Day12\West;
use maesierra\AdventOfCode2020\Day14\Mask;
use maesierra\AdventOfCode2020\Day14\Mem;
use maesierra\AdventOfCode2020\Day14\MemWithAddressDecoder;
use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;
use ReflectionClass;
use ReflectionException;

class Day14 {

    /**
     * @param $inputFile string
     * @return Instruction[]
     */
    private function parseInstructions(string $inputFile, \Closure $instructionFactory): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$result, $line) use($instructionFactory) {
            if (preg_match('/^(mask ?= ?([X10]+))|(mem\[(\d+)\] ?= ?(\d+))$/', $line, $matches)) {
                $result[] = $instructionFactory($matches);
            }
            return $result;
        }, []);
    }

    /**
     * Creates the runtime from the given instructions file
     * @param $inputFile
     * @return Runtime
     */
    private function createRuntimeV1($inputFile): Runtime {
        return new Runtime(
            $this->parseInstructions($inputFile, function($matches) {
                if ($matches[2]) {
                    return new Mask($matches[2]);
                } else  if ($matches[3]) {
                    return new Mem($matches[4], $matches[5]);
                } else {
                    return null;
                }
            }),
            ['mem' => [], 'mask' => str_split('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX')]
        );
    }

    /**
     * Creates the runtime from the given instructions file
     * @param $inputFile
     * @return Runtime
     */
    private function createRuntimeV2($inputFile): Runtime {
        return new Runtime(
            $this->parseInstructions($inputFile, function($matches) {
                if ($matches[2]) {
                    return new Mask($matches[2]);
                } else  if ($matches[3]) {
                    return new MemWithAddressDecoder($matches[4], $matches[5]);
                } else {
                    return null;
                }
            }),
            ['mem' => [], 'mask' => str_split('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX')]
        );
    }

    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile): int {
        $runtime = $this->createRuntimeV1($inputFile);
        $mem = $runtime->run()['mem'];
        return array_sum($mem);
    }

    /**
     * @param string $inputFile
     * @return int
     */
    public function question2(string $inputFile) {
        $runtime = $this->createRuntimeV2($inputFile);
        $mem = $runtime->run()['mem'];
        return array_sum($mem);
    }
}