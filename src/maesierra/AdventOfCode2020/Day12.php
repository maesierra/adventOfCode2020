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
use maesierra\AdventOfCode2020\Day8\Instruction;
use maesierra\AdventOfCode2020\Day8\Runtime;
use ReflectionClass;
use ReflectionException;

class Day12 {

    /**
     * @param $inputFile string
     * @return Instruction[]
     * @throws ReflectionException
     */
    private function parseInstructions(string $inputFile, $instructions, $params): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$result, $line) use($instructions, $params) {
            if (preg_match('/^('.implode('|', array_keys($instructions)).')(\d+)$/', $line, $matches)) {
                $instruction = $matches[1];
                $value = $matches[2];
                $class = $instructions[$instruction];
                $params = array_merge([$value], $params[$class]);
                $result[] = (new ReflectionClass($class))->newInstance(...$params);
            }
            return $result;
        }, []);
    }

    /**
     * Creates the runtime from the given instructions file
     * @param $inputFile
     * @return Runtime
     * @throws ReflectionException
     */
    private function createRuntimeV1($inputFile): Runtime {
        $allowedInstructions = [
            North::$NORTH => North::class,
            South::$SOUTH => South::class,
            West::$WEST => West::class,
            East::$EAST => East::class,
            Forward::$FORWARD => Forward::class,
            Left::$LEFT => Left::class,
            Right::$RIGHT => Right::class
        ];
        $params = [
            North::class => ['ship'],
            South::class => ['ship'],
            West::class => ['ship'],
            East::class => ['ship'],
            Forward::class => ['ship'],
            Left::class => ['ship'],
            Right::class => ['ship'],
        ];
        return new Runtime(
            $this->parseInstructions($inputFile, $allowedInstructions, $params),
            ['ship' => ['lat' => 0, 'long' => 0, 'direction' => 'E']]
        );
    }

    /**
     * Creates the runtime from the given instructions file
     * @param $inputFile
     * @return Runtime
     * @throws ReflectionException
     */
    private function createRuntimeV2($inputFile): Runtime {
        $allowedInstructions = [
            North::$NORTH => North::class,
            South::$SOUTH => South::class,
            West::$WEST => West::class,
            East::$EAST => East::class,
            ForwardTo::$FORWARD_TO => ForwardTo::class,
            RotateCounterClockwise::$ROTATE_COUNTERCLOCKWISE => RotateCounterClockwise::class,
            RotateClockwise::$ROTATE_CLOCKWISE => RotateClockwise::class
        ];
        $params = [
            North::class => ['waypoint'],
            South::class => ['waypoint'],
            West::class => ['waypoint'],
            East::class => ['waypoint'],
            RotateCounterClockwise::class => ['waypoint'],
            RotateClockwise::class => ['waypoint'],
            ForwardTo::class => ['waypoint', 'ship'],
        ];
        return new Runtime($this->parseInstructions($inputFile, $allowedInstructions, $params), [
            'ship' => ['lat' => 0, 'long' => 0, 'direction' => 'E'],
            'waypoint' => ['lat' => 1, 'long' => 10, 'direction' => 'N'],
        ]);
    }

    /**
     * Returns the highest password id from the codes in the input file
     * @param $inputFile
     * @return int
     * @throws ReflectionException
     */
    public function question1($inputFile): int {
        $runtime = $this->createRuntimeV1($inputFile);
        $ship = $runtime->run()['ship'];
        return abs($ship['lat']) + abs($ship['long']);
    }

    /**
     * @param string $inputFile
     * @return int
     * @throws ReflectionException
     */
    public function question2(string $inputFile) {
        $runtime = $this->createRuntimeV2($inputFile);
        $ship = $runtime->run()['ship'];
        return abs($ship['lat']) + abs($ship['long']);
    }
}