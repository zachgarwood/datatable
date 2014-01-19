<?php
/**
 * This file is part of the DataTable package.
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 *
 * @author Zach Garwood <zachgarwood@gmail.com>
 * @copyright Copyright (c) 2013 Zach Garwood
 * @license MIT
 */

namespace DataTable;

/**
 * Data table
 */
class Table
{
    /**
     * @var array of DataTable\Column
     */
    private $columns = array();

    /**
     * @var array of DataTable\Row
     */
    private $rows = array();

    /**
     * @api
     * @since 1.0.0
     *
     * @param Column $column
     * @throws InvalidArgumentException if a column already in the table
     *      contains the added column's label
     * @return self
     */
    public function addColumn(Column $column)
    {
        if (array_key_exists((string)$column, $this->columns)) {
            throw new \InvalidArgumentException("Column with label '$column' already exists!");
        }
        $this->columns[(string)$column] = $column;

        return $this;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @retun array of DataTable\Column
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Finds the column with the specified label
     *
     * @api
     * @since 1.0.0
     *
     * @param string $label
     * @return Column|false Returns false if no column is found
     */
    public function findColumn($label)
    {
        $column = false;
        foreach ($this->getColumns() as $col) {
            if ($col->getLabel() == $label) {
                $column = $col;
                break;
            }
        }

        return $column;
    }

    /**
     * @api
     * @since 1.1.0 Added ability to pass in an array of Cells
     * @since 1.0.0
     *
     * @param Row $row|array of Cell
     * @return self
     */
    public function insertRow($row)
    {
        if ($row instanceof Row) {
            $this->rows []= $row;
        } elseif (is_array($row)) {
            $newRow = new Row;
            foreach ($row as $cell) {
                $newRow->setCell($cell);
            }
            $this->insertRow($newRow);
        } else {
            throw new \InvalidArgumentException(
                "Argument 1 must be an instance of DataTable\Row or an array of DataTable\Cell"
            );
        }

        return $this;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return array of DataTable\Row
     */
    public function getRows()
    {
        return $this->rows;
    }
}
