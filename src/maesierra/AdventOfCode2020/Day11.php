<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;




class Day11 {
    const FREE = 'L';
    const FLOOR = '.';
    const OCCUPIED = '#';


    private function adjacent(array $state, int $row, int $column) {
        $seats = [];
        $top = max(0, $row - 1);
        $bottom = min(count($state) - 1, $row + 1);
        $left = max(0, $column - 1);
        $right = min(count($state[0]) - 1, $column + 1);
        for ($r = $top; $r <= $bottom; $r++) {
            for ($c = $left; $c <= $right; $c ++) {
                if (($r == $row) && ($column == $c)) {
                    continue;
                }
                $seats[] = $state[$r][$c];
            }
        }
        return $seats;
    }
    private function diagonals(array $state, int $row, int $column) {
        $diagonals = [
            'NW' => [],
            'N' => [],
            'NE' => [],
            'SW' => [],
            'S' => [],
            'SE' => []
        ];
        $width = count($state[0]);
        $height = count($state);
        for ($r = $row - 1; $r >= 0; $r--) {
            $diagonals['N'][] = $state[$r][$column];
            $diff = $row - $r;
            $val = $state[$r][$column - $diff] ?? null;
            if ($val) {
                $diagonals['NW'][] = $val;
            }
            $val = $state[$r][$column + $diff] ?? null;
            if ($val) {
                $diagonals['NE'][] = $val;
            }
        }
        for ($c = $column - 1; $c >= 0; $c--) {
            $diagonals['W'][] = $state[$row][$c];
        }
        for ($c = $column + 1; $c < $width; $c++) {
            $diagonals['E'][] = $state[$row][$c];
        }
        for ($r =  $row + 1; $r < $height; $r++) {
            $diagonals['S'][] = $state[$r][$column];
            $diff = $r - $row;
            $val = $state[$r][$column - $diff] ?? null;
            if ($val) {
                $diagonals['SW'][] = $val;
            }
            $val = $state[$r][$column + $diff] ?? null;
            if ($val) {
                $diagonals['SE'][] = $val;
            }
        }
        return array_map(function ($seats) {
            foreach ($seats as $pos => $s) {
                if ($s != self::FLOOR) {
                    $first = array_slice($seats, $pos);
                    return reset($first);
                }
            }
            return null;
        }, $diagonals);
    }

    private function adjacentWithStatus(array $state, $status, int $row, int $column): array {
        return array_filter($this->adjacent($state, $row, $column), function($seat) use($status) {
            return $seat == $status;
        });
    }

    private function countFree(array $state, int $row, int $column): int {
        return count($this->adjacentWithStatus($state, self::FREE, $row, $column));
    }

    private function countOccupied(array $state, int $row, int $column):int {
        return count($this->adjacentWithStatus($state, self::OCCUPIED, $row, $column));
    }

    public function applyRules(array $state):array {
        $new = $state;
        foreach ($state as $r => $row) {
            foreach ($row as $c => $seat) {
                if ($seat == self::FLOOR) {
                    continue;
                }
                $countOccupied = $this->countOccupied($state, $r, $c);
                if ($seat == self::FREE && $countOccupied == 0) {
                    $new[$r][$c] = self::OCCUPIED;
                } else {
                    if ($seat == self::OCCUPIED && $countOccupied >= 4) {
                        $new[$r][$c] = self::FREE;
                    }
                }

            }
        }
        return $new;
    }
    public function applyRules_v2(array $state):array {
        $new = $state;
        foreach ($state as $r => $row) {
            foreach ($row as $c => $seat) {
                if ($seat == self::FLOOR) {
                    continue;
                }
                $diagonals = $this->diagonals($state, $r, $c);
                $occupied = count(array_filter($diagonals, function ($seat) {
                    return $seat == self::OCCUPIED;
                }));
                if ($seat == self::FREE && $occupied == 0) {
                    $new[$r][$c] = self::OCCUPIED;
                } else {
                    if ($seat == self::OCCUPIED && $occupied >= 5) {
                        $new[$r][$c] = self::FREE;
                    }
                }

            }
        }
        return $new;
    }

    /**
     * Returns the number of seats after the state gets stabilizes
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile): int {
        $newState = array_map(function($line) {
            return str_split($line);
        }, explode("\n", file_get_contents($inputFile)));
        do {
            $state = $newState;
            $newState = $this->applyRules($state);
        } while($newState != $state);
        print_r($state);
        return count(array_filter(array_merge(...array_values($state)), function($s) {
           return $s == self::OCCUPIED;
        }));
    }


    /**
     * Returns the number of seats after the state gets stabilizes
     * @param $inputFile
     * @return int
     */
    public function question2($inputFile): int {
        $newState = array_map(function($line) {
            return str_split($line);
        }, explode("\n", file_get_contents($inputFile)));
        do {
            $state = $newState;
            $newState = $this->applyRules_v2($state);
        } while($newState != $state);
        print_r($state);
        return count(array_filter(array_merge(...array_values($state)), function($s) {
            return $s == self::OCCUPIED;
        }));
    }

}