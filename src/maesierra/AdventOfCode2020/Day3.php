<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;


use maesierra\AdventOfCode2020\Day3\Position;

class Day3 {


    /**
     * Count the trees (false) that will be hit if we traverse the grid with that slope
     * @param array $grid
     * @param Position $position current position
     * @param int $slopeX
     * @param int $slopeY
     * @return Position
     * y: ending position in y axis (x is always max x)
     * trees: number of trees traversed
     */
    private function countTreesInBlock(array $grid, Position $position, int $slopeX, int $slopeY) {
        $width = count($grid[0]);
        $height = count($grid);
        $x = $position->x % $width;
        $y = $position->y;
        $trees = $position->trees;
        echo "Traversing $position\n";
        do {
            if ($grid[$y][$x]) {
                $trees++;
            }
            $x += $slopeX;
            $y += $slopeY;
        } while ($x < $width && $y< $height);
        return new Position($width * ($position->block + 1) + ($x % $width), $y, $position->block + 1, $trees);
    }

    /**
     * @param string $inputFile
     * @return array|\bool[][]
     */
    protected function readGrid(string $inputFile)
    {
        //Convert the file into a boolean matrix
        return array_map(function ($line) {
            return array_map(function ($char) {
                return $char == '#';
            }, str_split($line));
        }, explode("\n", file_get_contents($inputFile)));
    }

    /**
     * @param array $grid
     * @param $slopeX
     * @param $slopeY
     * @return int
     */
    protected function countTrees(array $grid, $slopeX, $slopeY)
    {
        $end = count($grid);
        $position = new Position();
        while ($position->y < $end) {
            $position = $this->countTreesInBlock($grid, $position, $slopeX, $slopeY);
        }
        return $position->trees;
    }

    /**
     * Specifically, they need you to find the two entries that sum to 2020 and then multiply those two numbers together
     *
     * @param $inputFile string file containing a number per line
     * @return int two entries that sum to 2020 and then multiply those two numbers together
     * @throws \Exception
     */
    public function question1($inputFile) {
        $grid = $this->readGrid($inputFile);
        return $this->countTrees($grid, 3, 1);
    }

    public function question2(string $inputFile) {
        $grid = $this->readGrid($inputFile);
        $slope1 = $this->countTrees($grid, 1,1);
        $slope2 = $this->countTrees($grid, 3,1);
        $slope3 = $this->countTrees($grid, 5,1);
        $slope4 = $this->countTrees($grid, 7,1);
        $slope5 = $this->countTrees($grid, 1,2);
        return $slope1 * $slope2 * $slope3 * $slope4 * $slope5;
    }
}