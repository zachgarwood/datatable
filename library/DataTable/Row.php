<?php
namespace DataTable;

class Row
{
    private
        $cells = array();

    public function setCell(Cell $cell)
    {
        $this->cells[(string)$cell->getColumn()] = $cell;
        ksort($this->cells);

        return $this;
    }

    public function getCells()
    {
        return $this->cells;
    }
}

