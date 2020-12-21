<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;



use maesierra\AdventOfCode2020\Day20\Connection;
use maesierra\AdventOfCode2020\Day20\PlacedTile;
use maesierra\AdventOfCode2020\Day20\Tile;

class Day20 {

    /**
     * @param $inputFile
     * @return Tile[]
     */
    public function readTiles($inputFile):array {
        $separated = array_reduce(explode("\n", file_get_contents($inputFile)),
            function (&$result, $line) {
                if (preg_match('/^Tile (\d+):$/', $line, $matches)) {
                    $result[$matches[1]] = [];
                    return $result;
                } else if ($line) {
                    $keys = array_keys($result);
                    $last = end($keys);
                    $result[$last][] = str_split($line);
                }
                return $result;
            }, []);
        return  array_reduce(array_keys($separated), function(&$res, $id) use($separated) {
            $res[$id] = new Tile($id, $separated[$id]);
            return $res;
        }, []);
    }

    public function question1($inputFile):int {
        $tiles = $this->readTiles($inputFile);
        $borders = [Tile::BORDER_TOP, Tile::BORDER_BOTTOM, Tile::BORDER_LEFT, Tile::BORDER_RIGHT];
        foreach ($tiles as $tile) {
            foreach ($tiles as $tile2) {
                if ($tile->id == $tile2->id) {
                    continue;
                }
                foreach ($borders as $border) {
                    $tile->connections[$border] = array_merge($tile->connections[$border] ?? [], $tile->createConnections($tile2, $border));
                }
            }
        }
        //Create a map showing all the connection options for each tile
        $byBorder = array_reduce($borders, function (&$res, $border) use($tiles) {
            $res[$border] = array_map(function ($t) {return $t->id;}, array_filter($tiles, function($t) use($border) {
                return !empty($t->connections[$border]);
            }));
            return $res;
        }, []);
        //To be in the TL corner it needs to be in B and R
        $candidates = array_filter($byBorder[Tile::BORDER_BOTTOM], function ($v) use($byBorder) {
            return in_array($v, $byBorder[Tile::BORDER_RIGHT]);
        });
        foreach ($candidates as $tile) {
            $grid = $this->createGrid($tiles[$tile], $tiles);
            if ($grid) {
                echo "\n------------ Found!!! ---------------\n";
                echo "{$this->gridToString($grid)}\n";
                $len = count($grid);
                return $grid[0][0]->tile->id *
                       $grid[0][$len - 1]->tile->id *
                       $grid[$len - 1][0]->tile->id *
                       $grid[$len - 1][$len - 1]->tile->id;
            }
        }
        return 0;
    }

    /**
     * @param $startTile Tile
     * @param $tiles Tile[]
     * @return PlacedTile[][]
     */
    private function createGrid(Tile $startTile, array $tiles): array {
        $len = (int) ceil(sqrt(count($tiles)));
        /** @var PlacedTile[][][] $stack */
        $stack = [];
        $stack[0] = $this->getRowOptions($startTile, null, $len);
        if (!$stack[0]) {
            return [];
        }
        $i = 0;
        while ($i < $len) {
            $row = $stack[$i][0];
            $grid = [];
            for ($j = 0; $j <= $i; $j++) {
                $grid[$j] = $stack[$j][0];
            }
            echo "-------------------------------------\n";
            echo "{$this->gridToString($grid)}\n";
            $i++;
            $connections = $row[0]->tile->getBottomConnections($row[0]->rotation);
            foreach ($connections as $connection) {
                /** @var Connection $connection */
                $rowOptions = $this->getRowOptions($connection->to, $connection->toType, $len, $grid);
                $stack[$i] = array_merge($stack[$i] ?? [], $rowOptions);
            }
            if (!$stack[$i]) {
                $row = null;
                //backtrack
                while (!$row && $i > 0) {
                    $i--;
                    array_shift($stack[$i]);
                    $row = $stack[$i][0] ?? null;
                }
                if (!$row) {
                    //No more backtracking
                    return [];
                }
            } else {
                if ($i == $len - 1) {
                    //Found!!!
                    $grid = array_map(function ($row) {
                        return $row[0];
                    }, $stack);
                    return $grid;
                }
            }
        }
        return [];
    }


    /**
     * @param array $grid PlacedTile[][]
     * @return string[]
     */
    private function flattenPlacedTiles(array $grid):array {
        return array_reduce($grid, function (&$res, $row) {
            return array_reduce($row, function(&$r, $t) {
                $r[$t->tile->id] = $t->tile;
                return $r;
            }, $res);
        }, []);

    }

    /**
     * @param Tile $startTile
     * @param string|null $type string connection type
     * @param int $len
     * @param PlacedTile[][] $grid
     * @return PlacedTile[][]
     */
    private function getRowOptions(Tile $startTile, ?string $type, int $len, array $grid = []):array {
        //None of the connections can be to any of nodes already placed
        $usedTiles = $this->flattenPlacedTiles($grid);
        $connections = array_filter($startTile->getRightConnections($type), function($c) use($usedTiles) {
          return !isset($usedTiles[$c->to->id]);
        });
        if ($len == 2) {
            $prevRow = $grid ? end($grid) : [];
            $prevRow = array_slice($prevRow, -2);
            $validConnections = array_filter($connections, function ($c) use ($prevRow) {
                /** @var Connection $c */
                return !$prevRow || (
                        $prevRow[0]->tile->canConnect($c->from, Tile::BORDER_BOTTOM, $c->fromType) &&
                        $prevRow[1]->tile->canConnect($c->to, Tile::BORDER_BOTTOM, $c->toType)
                );
            });
            return array_map(function($c) use($prevRow) {
                $from = new PlacedTile($c->from, $c->fromType);
                $to = new PlacedTile($c->to, $c->toType);
                if ($prevRow) {
                    $prevRow[0]->bottom = $from;
                    $prevRow[1]->bottom = $to;
                }
                return [$from, $to];
            }, array_values($validConnections));
        }
        $options = [];
        foreach ($connections as $connection) {
            /** @var Connection $connection */
            $newOptions = $this->getRowOptions($connection->to, $connection->toType, $len - 1, $grid);
            if ($newOptions) {
                $options = array_reduce($newOptions, function(&$res, $placedTiles) use($connection) {
                    /** @var PlacedTile[] $row */
                    $row = $placedTiles;
                    array_unshift($row, new PlacedTile($connection->from, $connection->fromType));
                    //Make sure there are no duplicates in the row
                    $ids = array_map(function($t) {
                        return $t->tile->id;
                    }, $row);
                    if (count(array_unique($ids)) == count($ids)) {
                        $res[] = $row;
                    }
                    return $res;
                }, $options);
            }
        }
        return $options;
    }

    /**
     * @param array $grid
     * @return string
     */
    private function gridToString(array $grid): string
    {
        $text = implode("\n", array_map(function ($g) {
            return implode("  ", $g);
        }, $grid));
        return $text;
    }


}