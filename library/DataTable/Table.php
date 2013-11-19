<?php
namespace DataTable;

class Table
{
    private
        $columns = array(),
        $rows = array();

    public function addColumn(Column $column)
    {
        if (array_key_exists((string)$column, $this->columns)) {
            throw new \InvalidArgumentException(
                "Column with label '$column' already exists!"
            );
        }
        $this->columns[(string)$column] = $column;

        return $this;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function findColumn($label)
    {
        $column = null;
        foreach ($this->getColumns() as $col) {
            if ($col->getLabel() == $label) {
                $column = $col;
                break;
            }
        }

        return $column;
    }

    public function insertRow(Row $row)
    {
        $this->rows []= $row;

        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }
}

