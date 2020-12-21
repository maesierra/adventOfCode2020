<?php


namespace maesierra\AdventOfCode2020\Day20;


class PlacedTile {

    /** @var Tile */
    public $tile;
    public $rotation;

    /**
     * PlacedTile constructor.
     * @param Tile $tile
     * @param $rotation
     */
    public function __construct(Tile $tile, $rotation)
    {
        $this->tile = $tile;
        $this->rotation = $rotation;
    }

    public function __toString() {
        return "{$this->tile->id} {$this->rotation}";
    }


}