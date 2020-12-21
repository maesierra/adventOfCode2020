<?php


namespace maesierra\AdventOfCode2020\Day20;


class Tile {

    const BORDER_TOP = 'T';
    const BORDER_BOTTOM = 'B';
    const BORDER_LEFT = 'L';
    const BORDER_RIGHT = 'R';

    /** @var string[][] */
    public $borders;
    /** @var Connection[] */
    public $connections;

    public $id;
    /** @var string[][] */
    public $image;

    /**
     * Tile constructor.
     * @param $id
     * @param string[][] $image
     */
    public function __construct($id, array $image) {
        $this->id = $id;
        $this->image = $image;
        $top = $image[0];
        $bottom = $image[count($image) - 1];
        $left = array_column($image, 0);
        $right = array_column($image, count($image) - 1);
        $topReversed = array_reverse($top);
        $bottomReversed = array_reverse($bottom);
        $leftReversed = array_reverse($left);
        $rightReversed = array_reverse($right);
        $this->borders = [
            self::BORDER_TOP => [
                Connection::CONNECTION_NORMAL => $top,
                Connection::CONNECTION_FLIP_X => $topReversed,
                Connection::CONNECTION_FLIP_Y => $bottom,
                Connection::CONNECTION_ROTATED180 => $bottomReversed,
                Connection::CONNECTION_ROTATED90 => $leftReversed,
                Connection::CONNECTION_ROTATED270 => $right,
                Connection::CONNECTION_ROTATED90_FLIP_X => $left,
                Connection::CONNECTION_ROTATED90_FLIP_Y => $rightReversed,
            ],
            self::BORDER_BOTTOM => [
                Connection::CONNECTION_NORMAL => $bottom,
                Connection::CONNECTION_FLIP_X => $bottomReversed,
                Connection::CONNECTION_FLIP_Y => $top,
                Connection::CONNECTION_ROTATED90 => $rightReversed,
                Connection::CONNECTION_ROTATED180 => $topReversed,
                Connection::CONNECTION_ROTATED270 => $left,
                Connection::CONNECTION_ROTATED90_FLIP_X => $right,
                Connection::CONNECTION_ROTATED90_FLIP_Y => $leftReversed,
            ],
            self::BORDER_LEFT => [
                Connection::CONNECTION_NORMAL => $left,
                Connection::CONNECTION_FLIP_X => $right,
                Connection::CONNECTION_FLIP_Y => $leftReversed,
                Connection::CONNECTION_ROTATED90 => $bottom,
                Connection::CONNECTION_ROTATED180 => $rightReversed,
                Connection::CONNECTION_ROTATED270 => $topReversed,
                Connection::CONNECTION_ROTATED90_FLIP_X => $top,
                Connection::CONNECTION_ROTATED90_FLIP_Y => $bottomReversed,
            ],
            self::BORDER_RIGHT => [
                Connection::CONNECTION_NORMAL => $right,
                Connection::CONNECTION_FLIP_X => $left,
                Connection::CONNECTION_FLIP_Y => $rightReversed,
                Connection::CONNECTION_ROTATED90 => $top,
                Connection::CONNECTION_ROTATED180 => $leftReversed,
                Connection::CONNECTION_ROTATED270 => $bottomReversed,
                Connection::CONNECTION_ROTATED90_FLIP_X => $bottom,
                Connection::CONNECTION_ROTATED90_FLIP_Y => $topReversed,
            ]
        ];
        $this->connections = [];
    }

    /**
     * @param Tile $tile
     * @param $borderType
     * @return Connection[]
     */
    public function createConnections(Tile $tile, $borderType):array {
        $connections = [];
        foreach ($this->borders[$borderType] as $fromType => $from) {
            foreach ($tile->borders[Tile::oposite($borderType)] as $toType => $to) {
                if ($from == $to) {
                    $connections[] = new Connection($this, $fromType, $tile, $toType);
                }
            }
        }
        return $connections;
    }

    public static function oposite($borderType) {
        switch ($borderType) {
            case self::BORDER_TOP:
                return self::BORDER_BOTTOM;
            case self::BORDER_BOTTOM:
                return self::BORDER_TOP;
            case self::BORDER_LEFT:
                return self::BORDER_RIGHT;
            case self::BORDER_RIGHT:
                return self::BORDER_LEFT;
        }
    }

    /**
     * @param $tile Tile
     * @param $border string
     * @param string $type
     * @return bool
     */
    public function canConnect(Tile $tile, string $border, string $type): bool {
        foreach ($this->connections[$border] as $connection) {
            /** @var Connection $connection */
            if ($connection->to->id == $tile->id && $connection->toType == $type) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $border
     * @param string $type
     * @return Connection[]
     */
    public function getConnections(string $border, $type = null):array {
        return array_filter($this->connections[$border], function($c) use($type) {
            /** @var Connection $c */
            return !$type || $c->fromType == $type;
        });
    }

    /**
     * @param string $type
     * @return Connection[]
     */
    public function getRightConnections($type = null):array {
        return $this->getConnections(Tile::BORDER_RIGHT, $type);
    }

    /**
     * @param string $type
     * @return Connection[]
     */
    public function getBottomConnections($type = null):array {
        return $this->getConnections(Tile::BORDER_BOTTOM, $type);
    }

}