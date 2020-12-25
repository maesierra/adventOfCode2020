<?php


namespace maesierra\AdventOfCode2020\Day24;


class Tile {

    static $seed = 0;

    const DIRECTION_E = 'e';
    const DIRECTION_SE = 'se';
    const DIRECTION_SW = 'sw';
    const DIRECTION_W = 'w';
    const DIRECTION_NW = 'nw';
    const DIRECTION_NE = 'ne';

    const ALL_DIRECTIONS = [
        Tile::DIRECTION_W,
        Tile::DIRECTION_NW,
        Tile::DIRECTION_NE,
        Tile::DIRECTION_E,
        Tile::DIRECTION_SE,
        Tile::DIRECTION_SW
    ];
    const COLOUR_WHITE = 'white';

    const COLOUR_BLACK = 'black';


    public $id;
    public $colour = self::COLOUR_WHITE;
    public $connected = [
        self::DIRECTION_E => null,
        self::DIRECTION_SE => null,
        self::DIRECTION_SW => null,
        self::DIRECTION_W => null,
        self::DIRECTION_NW => null,
        self::DIRECTION_NE => null,
    ];

    /**
     * Tile constructor.
     */
    public function __construct() {
        $this->id = self::$seed++;
    }


    public function flip():void {
        $this->colour = $this->colour == self::COLOUR_WHITE ? self::COLOUR_BLACK : self::COLOUR_WHITE;
    }

    public function connect(Tile $tile, $direction) {
        $this->connected[$direction] = $tile;
        $tile->connected[self::opposite($direction)] = $this;

    }

    public static function opposite($direction):string {
        switch ($direction) {
            case self::DIRECTION_E:
                return self::DIRECTION_W;
            case self::DIRECTION_W:
                return self::DIRECTION_E;
            case self::DIRECTION_SE:
                return self::DIRECTION_NW;
            case self::DIRECTION_SW:
                return self::DIRECTION_NE;
            case self::DIRECTION_NE:
                return self::DIRECTION_SW;
            case self::DIRECTION_NW:
                return self::DIRECTION_SE;
        }
    }

    public function isBlack():bool {
        return $this->colour == Tile::COLOUR_BLACK;
    }

    public function isWhite():bool {
        return $this->colour == Tile::COLOUR_WHITE;
    }

    public function isBorder(): bool {
        return array_filter($this->connected, function($t) {
            return is_null($t);
        }) ? true : false;
    }

    public static function neighbour($direction, $distance = 1): string {
        $nDirection = count(self::ALL_DIRECTIONS);
        $pos = array_search($direction, self::ALL_DIRECTIONS) + $distance;
        $pos = $pos < 0 ? $nDirection + $pos : $pos;
        $pos = $pos >= $nDirection ? $pos - $nDirection : $pos;
        return self::ALL_DIRECTIONS[$pos];
    }

}