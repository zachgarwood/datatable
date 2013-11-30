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
 * Data table row
 */
class Row
{
    /**
     * @var array of DataTable\Cell
     */
    private $cells = array();

    /**
     * @api
     * @since 1.0.0
     *
     * @param DataTable\Cell $cell
     * @return self
     */
    public function setCell(Cell $cell)
    {
        $this->cells[(string)$cell->getColumn()] = $cell;
        ksort($this->cells);

        return $this;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return array of DataTable\Cell
     */
    public function getCells()
    {
        return $this->cells;
    }
}

