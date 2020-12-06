<?php


namespace maesierra\AdventOfCode2020\Day5;


class Seat {

    public $row;
    public $colum;
    public $id;

    /**
     * Seat constructor.
     * @param $row
     * @param $column
     * @param $id
     */
    public function __construct($row, $column, $id = null)
    {
        $this->row = $row;
        $this->colum = $column;
        $this->id = $id ?: $row * 8 + $column;
    }


    public function __toString() {
        return "{$this->id}:{$this->row}";
    }

}