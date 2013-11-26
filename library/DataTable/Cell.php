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
 * DataTable data table cell
 */
class Cell
{
    /**
     * @api
     * @since 1.0.0
     *
     * @var string
     */
    public $label;

    /**
     * @api
     * @since 1.0.0
     *
     * @var boolean|integer|string|DateTime
     */
    public $value;

    /**
     * @var DataTable\Column
     */
    private $column;

    /**
     * @api
     * @since 1.0.0
     *
     * @param DataTable\Column $column
     * @param integer|string|DateTime $value
     * @param string|null $label
     * @throws InvalidArgumentException if the supplied value is not of the
     *      supplied column's data type
     */
    public function __construct(Column $column, $value, $label = null)
    {
        $this->column = $column;
        if (!$this->column->isValueValidType($value)) {
            throw new \InvalidArgumentException(
                "'$value' is not of type '{$column->getType()}'!"
            );
        }
        $this->value = $value;
        $this->label = $label;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return DataTable\Column
     */
    public function getColumn()
    {
        return $this->column;
    }
}

