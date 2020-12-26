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

    public function toImage(): array {
        $image = [];
        $len = count($this->tile->image);
        //Remove borders
        for ($i = 1; $i < $len - 1; $i++) {
            $image[$i - 1] = array_slice($this->tile->image[$i], 1, $len - 2);
        }
        return $image;
    }

    public function __toString() {
        return "{$this->tile->id} {$this->rotation}";
    }


}