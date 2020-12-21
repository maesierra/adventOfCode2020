<?php


namespace maesierra\AdventOfCode2020\Day20;


class Connection {

    const CONNECTION_FLIP_X = 'X';
    const CONNECTION_FLIP_Y = 'Y';
    const CONNECTION_ROTATED90 = 'R90';
    const CONNECTION_ROTATED180 = 'R180';
    const CONNECTION_ROTATED270 = 'R270';
    const CONNECTION_ROTATED90_FLIP_X = 'R90X';
    const CONNECTION_ROTATED90_FLIP_Y = 'R90Y';
    const CONNECTION_NORMAL = 'N';


    /** @var Tile */
    public $to;
    public $toType;
    /** @var Tile */
    public $from;
    public $fromType;

    /**
     * Connection constructor.
     * @param Tile $to
     * @param $toType
     * @param Tile $from
     * @param $fromType
     */
    public function __construct(Tile $from, $fromType, Tile $to, $toType) {
        $this->to = $to;
        $this->toType = $toType;
        $this->from = $from;
        $this->fromType = $fromType;
    }

    /**
     * @param $tile Tile
     * @param $border string
     * @param string|null $type
     * @return bool
     */
    public function canConnect(Tile $tile, string $border, ?string $type): bool {
        foreach ($tile->connections[$border] as $connection) {
            /** @var Connection $connection */
            if ($connection->to->id == $this->from->id && (!$type || $connection->toType == $type)) {
                return true;
            }
        }
        return false;
    }

}