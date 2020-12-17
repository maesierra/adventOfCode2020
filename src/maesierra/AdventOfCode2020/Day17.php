<?php
/**
 * Created by PhpStorm.
 * User: maesierra
 * Date: 01/12/2020
 * Time: 20:46
 */

namespace maesierra\AdventOfCode2020;




class Day17 {
    const INACTIVE = '.';
    const ACTIVE = '#';

    /**
     * @param $empty
     * @param $min
     * @param $max
     * @return array
     */
    public function filterRange($empty, $min, $max): array
    {
        if (count($empty) > 1) {
            $start = $empty[0];
            $end = end($empty);
            return array_filter(range($min, $max), function ($n) use ($start, $end) {
                return $n > $start && $n < $end;
            });
        } else {
            return [];
        }
    }

    public function next4d(array $state) {
        $current = $state; //Clone the state
        //expand by 1 inactive in all axis
        $minW = array_keys($current)[0] - 1;
        $maxW = array_keys($current)[count($current) - 1] + 1;
        $minZ = array_keys($current[0])[0] - 1;
        $maxZ = array_keys($current[0])[count($current[0]) - 1] + 1;
        $minY = array_keys($current[0][0])[0] - 1;
        $maxY = array_keys($current[0][0])[count($current[0][0]) - 1] + 1;
        $minX = array_keys($current[0][0][0])[0] - 1;
        $maxX = array_keys($current[0][0][0])[count($current[0][0][0]) - 1] + 1;
        $emptyRow = array_combine(range($minX , $maxX), array_fill(0, $maxX - $minX + 1, self::INACTIVE));
        $emptyPlane = array_reduce(range($minY, $maxY), function(&$res, $y) use($emptyRow) {
            $res[$y] = $emptyRow;
            return $res;
        }, []);
        $emptyCube = array_reduce(range($minZ, $maxZ), function(&$res, $z) use($emptyPlane) {
            $res[$z] = $emptyPlane;
            return $res;
        }, []);
        $current[$minW] = $emptyCube;
        $current[$maxW] = $emptyCube;
        ksort($current);
        foreach ($current as $w => $cube) {
            $current[$w][$minZ] = $emptyPlane;
            $current[$w][$maxZ] = $emptyPlane;
            foreach ($cube as $z => $plane) {
                $current[$w][$z][$minY] = $emptyRow;
                $current[$w][$z][$maxY] = $emptyRow;
                foreach (array_keys($plane) as $y) {
                    $current[$w][$z][$y][$minY] = self::INACTIVE;
                    $current[$w][$z][$y][$maxY] = self::INACTIVE;
                    ksort($current[$w][$z][$y]);
                }
                ksort($current[$w][$z]);
            }
            ksort($current[$w]);
        }
        $new = [];
        foreach ($current as $w => $cube) {
            foreach ($cube as $z => $plane) {
                foreach ($plane as $y => $row) {
                    foreach ($row as $x => $elem) {
                        $nActive = $this->countAdjacentActive4d($current, $w, $x, $y, $z);
                        if ($elem == self::ACTIVE) {
                            $newElem = ($nActive == 2 || $nActive == 3) ? self::ACTIVE : self::INACTIVE;
                        } else {
                            $newElem = ($nActive == 3) ? self::ACTIVE : self::INACTIVE;
                        }
                        $new[$w][$z][$y][$x] = $newElem;
                    }
                }
            }
        }
        return $new;

    }


    private function adjacent3d(array $state, int $x, int $y, int $z): array
    {
        $cubes = [];

        for ($iz = $z - 1; $iz <= $z + 1; $iz++) {
            $cubes[$iz] = [];
            for ($iy = $y - 1; $iy <= $y + 1; $iy++) {
                $cubes[$iz][$iy] = [];
                for ($ix = $x - 1; $ix <= $x + 1; $ix++) {
                    if ($x !== $ix || $y !== $iy || $z !== $iz) {
                        $cubes[$iz][$iy][$ix] = (($state[$iz] ?? [])[$iy] ?? [])[$ix] ?? self::INACTIVE;
                    }
                }
            }
        }
        return $cubes;
    }

    private function adjacent4d(array $state, int $w, int $x, int $y, int $z) {
        $elements = [];
        for ($iw = $w - 1; $iw <= $w + 1; $iw++) {
            $elements[$iw] = [];
            for ($iz = $z - 1; $iz <= $z + 1; $iz++) {
                $elements[$iw][$iz] = [];
                for ($iy = $y - 1; $iy <= $y + 1; $iy++) {
                    $elements[$iw][$iz][$iy] = [];
                    for ($ix = $x - 1; $ix <= $x + 1; $ix++) {
                        if ($x !== $ix || $y !== $iy || $z !== $iz || $w !== $iw) {
                            $elements[$iw][$iz][$iy][$ix] = ((($state[$iw] ?? [])[$iz] ?? [])[$iy] ?? [])[$ix] ?? self::INACTIVE;
                        }
                    }
                }
            }
        }

        return $elements;
    }

    private function countAdjacentActive3d(array $state, int $x, int $y, int $z): int {
        $adjacent = $this->adjacent3d($state, $x, $y, $z);
        $active = 0;
        foreach ($adjacent as $plane) {
            foreach ($plane as $row) {
                $active = array_reduce($row, function($sum, $cube) {
                    if ($cube == self::ACTIVE) {
                        $sum++;
                    }
                    return $sum;
                }, $active);
            }
        }
        return $active;
    }

    private function countAdjacentActive4d(array $state, int $w, int $x, int $y, int $z): int {
        $adjacent = $this->adjacent4d($state, $w, $x, $y, $z);
        $active = 0;
        foreach ($adjacent as $cube) {
            foreach ($cube as $plane) {
                foreach ($plane as $row) {
                    $active = array_reduce($row, function ($sum, $elem) {
                        if ($elem == self::ACTIVE) {
                            $sum++;
                        }
                        return $sum;
                    }, $active);
                }
            }
        }
        return $active;
    }

    public function next3d(array $state):array {
        $current = $state; //Clone the state
        //expand by 1 inactive in all axis
        $minZ = array_keys($current)[0] - 1;
        $maxZ = array_keys($current)[count($current) - 1] + 1;
        $minY = array_keys($current[0])[0] - 1;
        $maxY = array_keys($current[0])[count($current[0]) - 1] + 1;
        $minX = array_keys($current[0][0])[0] - 1;
        $maxX = array_keys($current[0][0])[count($current[0][0]) - 1] + 1;
        $emptyRow = array_combine(range($minX , $maxX), array_fill(0, $maxX - $minX + 1, self::INACTIVE));
        $emptyPlane = array_reduce(range($minY, $maxY), function(&$res, $y) use($emptyRow) {
            $res[$y] = $emptyRow;
            return $res;
        }, []);
        $current[$minZ] = $emptyPlane;
        $current[$maxZ] = $emptyPlane;
        ksort($current);
        foreach ($current as $z => $plane) {
            $current[$z][$minY] = $emptyRow;
            $current[$z][$maxX] = $emptyRow;
            foreach (array_keys($plane) as $y) {
                $current[$z][$y][$minX] = self::INACTIVE;
                $current[$z][$y][$maxX] = self::INACTIVE;
                ksort($current[$z][$y]);
            }
            ksort($current[$z]);
        }
        $new = [];
        foreach ($current as $z => $plane) {
            foreach ($plane as $y => $row) {
                foreach ($row as $x => $cube) {
                    $nActive = $this->countAdjacentActive3d($current, $x, $y, $z);
                    if ($cube == self::ACTIVE) {
                        $newCube = ($nActive == 2 || $nActive == 3) ? self::ACTIVE : self::INACTIVE;
                    } else {
                        $newCube = ($nActive == 3) ? self::ACTIVE : self::INACTIVE;
                    }
                    $new[$z][$y][$x] = $newCube;
                }
            }
        }
        return $new;
    }

    public function countActive3d($state): int
    {
        $nActive = 0;
        foreach ($state as $z => $plane) {
            foreach ($plane as $y => $row) {
                $nActive += count(array_filter($row, function($cube) {
                    return $cube == self::ACTIVE;
                }));
            }
        }
        return $nActive;
    }

    public function countActive4d($state): int
    {
        $nActive = 0;
        foreach ($state as $w => $cube) {
            foreach ($cube as $z => $plane) {
                foreach ($plane as $y => $row) {
                    $nActive += count(array_filter($row, function ($elem) {
                        return $elem == self::ACTIVE;
                    }));
                }
            }
        }
        return $nActive;
    }

    /**
     * Returns the number of seats after the state gets stabilizes
     * @param $inputFile
     * @return int
     */
    public function question1($inputFile): int {
        $state = [0 => array_map(function($line) {
            return str_split($line);
        }, explode("\n", file_get_contents($inputFile)))];
        for ($i = 0; $i < 6; $i++) {
            $state = $this->next3d($state);
        }
        return $this->countActive3d($state);
    }


    /**
     * Returns the number of seats after the state gets stabilizes
     * @param $inputFile
     * @return int
     */
    public function question2($inputFile): int {
        $state = [0 => [0 => array_map(function($line) {
            return str_split($line);
        }, explode("\n", file_get_contents($inputFile)))]];
        for ($i = 0; $i < 6; $i++) {
            $state = $this->next4d($state);
        }
        return $this->countActive4d($state);
    }

}