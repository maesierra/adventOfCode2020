<?php


namespace maesierra\AdventOfCode2020;


use Exception;
use maesierra\AdventOfCode2020\Day24\Tile;

class Day24 {

    /**
     * @param string $inputFile
     * @return array
     * @throws Exception
     */
    private function readDirections(string $inputFile): array {
        return array_reduce(explode("\n", file_get_contents($inputFile)), function(&$res, $line)  {
            if (!trim($line)) {
                return $res;
            }
            $original = $line;
            $directions = [];
            while ($line) {
                $direction = substr($line, 0, 1);
                if (in_array($direction, [Tile::DIRECTION_E, Tile::DIRECTION_W])) {
                    $directions[] = $direction;
                    $line = substr($line, 1);
                } else {
                    $directions[] = substr($line, 0, 2);
                    $line = substr($line, 2);
                }
            }
            $check = array_reduce(array_unique($directions), function($res, $d) {
                return $res && in_array($d, Tile::ALL_DIRECTIONS);
            }, true);
            if ($check != Tile::ALL_DIRECTIONS || implode("", $directions) != $original) {
                throw new Exception("Invalid line parsed $original");
            }
            $res[] = $directions;
            return $res;

        }, []);
    }

    /**
     * @param $size
     * @return Tile
     */
    private function createGrid($size):Tile {
        $prevRow = null;
        $start = null;
        for ($j = 0; $j < $size; $j++) {
            $tile = new Tile();
            $rowStart = $tile;
            if ($j == 0) {
                $start = $rowStart;
            }
            $oddRow = $j % 2 == 1;
            $prev = null;
            for ($i = 0; $i < $size - 1; $i++) {
                $tile->connect(new Tile(), Tile::DIRECTION_E);
                if ($prevRow) {
                    if ($oddRow) {
                        $tile->connect($prevRow, Tile::DIRECTION_NW);
                        if ($i != 0) {
                            $prev->connect($prevRow, Tile::DIRECTION_NE);
                        }
                        $prev = $tile;
                    } else {
                        $tile->connect($prevRow, Tile::DIRECTION_NE);
                        if ($i != 0) {
                            $tile->connect($prev, Tile::DIRECTION_NW);
                        }
                        $prev = $prevRow;
                    }
                    $prevRow = $prevRow->connected[Tile::DIRECTION_E];
                }
                $tile = $tile->connected[Tile::DIRECTION_E];
            }
            $prevRow = $rowStart;
        }
        $half = (int) $size / 2;
        $tile = $start;
        for ($i = 0; $i < $half; $i++) {
            $tile = $tile->connected[Tile::DIRECTION_E];
        }
        for ($i = 0; $i < $half; $i++) {
            $tile = $tile->connected[$i % 2 == 0 ? Tile::DIRECTION_SW : Tile::DIRECTION_SE ];
        }
        return $tile;
    }

    /**
     * @param Tile $center
     * @param array $direction
     * @return Tile
     * @throws Exception
     */
    private function moveTo(Tile $center, array $direction): Tile
    {
        $tile = $center;
        foreach ($direction as $move => $next) {
            $tile = $tile->connected[$next];
            if (!$tile) {
                throw new Exception("Grid not big enough");
            }
        }
        return $tile;
    }

    /**
     * @param Tile[] $blackTiles
     * @return Tile[]
     * @throws Exception
     */
    private function applyRules(array $blackTiles):array {
        $flip = [];
        foreach ($blackTiles as $id => $tile) {
            if ($tile->isBorder()) {
                throw new Exception("Grid nto big enough");
            }
            /** @var Tile[] $whiteNeighbours */
            $whiteNeighbours = array_filter($tile->connected, function($t) {
                /** @var Tile $t */
               return $t->isWhite();
            });
            if (count($whiteNeighbours) == 6 /*zero black*/ || count($whiteNeighbours) < 4 /*more then 2 blacks*/) {
                $flip[$tile->id] = $tile;
            }
            //Iterate the white neighbours to see if we need to flip them
            foreach ($whiteNeighbours as $t) {
                if ($t->isBorder()) {
                    throw new Exception("Grid nto big enough");
                }
                $countBlack = array_reduce($t->connected, function($c, $n) {
                    /** @var $n Tile */
                    return $c + ($n->isBlack() ? 1 : 0);
                }, 0);
                if ($countBlack == 2 && !isset($flip[$t->id])) {
                    $flip[$t->id] = $t;
                }
            }
        }
        foreach ($flip as $tile) {
            $tile->flip();
            if ($tile->isBlack()) {
                $blackTiles[$tile->id] = $tile;
            } else {
                unset($blackTiles[$tile->id]);
            }
            echo "{$tile->id} flipped to {$tile->colour}\n";
        }
        return $blackTiles;
    }

    /**
     * @param string $inputFile
     * @return int
     * @throws Exception
     */
    public function question1(string $inputFile):int {
        $count = 0;
        /** @var string[][] $directions */
        $directions = $this->readDirections($inputFile);
        $center = $this->createGrid(100);
        foreach ($directions as $pos => $direction) {
            echo "$pos => Moving to " . implode(",", $direction) . "\n";
            $tile = $this->moveTo($center, $direction);
            $tile->flip();
            echo "{$tile->id} flipped to {$tile->colour}\n";
            $count += $tile->isBlack() ? 1 : -1;
        }
        return $count;
    }

    /**
     * @param string $inputFile
     * @param int $nDays
     * @return int
     * @throws Exception
     */
    public function question2(string $inputFile, int $nDays, $gridSize = 100): int {
        /** @var string[][] $directions */
        $directions = $this->readDirections($inputFile);
        $center = $this->createGrid($gridSize);
        $blackTiles = [];
        foreach ($directions as $pos => $direction) {
            $tile = $this->moveTo($center, $direction);
            $tile->flip();
            if ($tile->isBlack()) {
                $blackTiles[$tile->id] = $tile;
            } else {
                unset($blackTiles[$tile->id]);
            }
            echo "{$tile->id} flipped to {$tile->colour}\n";
        }

        for ($day = 1; $day <= $nDays; $day++) {
            echo "Day $day\n";
            $blackTiles = $this->applyRules($blackTiles);
        }
        return count($blackTiles);
    }

}
