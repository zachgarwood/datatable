<?php
namespace DataTable;

class Data
{
    private
        $_columns = array(),
        $_rows = array();

    public function addColumn(Column $column)
    {
        if (array_key_exists((string)$column, $this->_columns)) {
            throw new \InvalidArgumentException(
                "Column with label '$column' already exists!"
            );
        }
        $this->_columns[(string)$column] = $column;
        ksort($this->_columns);

        return $this;
    }

    public function getColumns()
    {
        return $this->_columns;
    }

    public function insertRow(Row $row)
    {
        $this->_rows []= $row;

        return $this;
    }

    public function getRows()
    {
        return $this->_rows;
    }
}

