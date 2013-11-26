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
 * DataTable data table column
 */
class Column
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_DATE = 'date';         // Cells of types date and datetime must
    const TYPE_DATETIME = 'datetime'; // have DateTime objects as values.
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';

    /**
     * @api
     * @since 1.0.0
     *
     * @var string[] An array of the class's constants
     */
    public static
        $types = [
            self::TYPE_BOOLEAN,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_NUMBER,
            self::TYPE_STRING,
        ];

    /**
     * @var string
     */
    private $label;

    /**
     * @var string One of those listed in the $types array
     */
    private $type;

    /**
     * @api
     * @since 1.0.0
     *
     * @param string $type
     * @param string $label
     * @throws InvalidArgumentException if supplied type is not one of those in
     *      the types array
     */
    public function __construct($type, $label)
    {
        if (!in_array($type, self::$types)) {
            throw new \InvalidArgumentException(
                "'$type' is not a valid data type!"
            );
        }
        $this->type = $type;
        $this->label = $label;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return string
     */
    public function getId()
    {
        return $this->label . $this->type;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Determines if the supplied value is of the correct type
     *
     * Note: TYPE_DATE and TYPE_DATETIME values must be DateTime objects.
     *
     * @api
     * @since 1.0.0
     *
     * @param string $value
     * @return boolean
     */
    public function isValueValidType($value)
    {
        switch ($this->getType()) {
        case self::TYPE_BOOLEAN:
            $isValid = is_bool($value);
            break;
        case self::TYPE_DATE:
        case self::TYPE_DATETIME:
            $isValid = is_object($value) and get_class($value) == 'DateTime';
            break;
        case self::TYPE_NUMBER:
            $isValid = is_numeric($value);
            break;
        case self::TYPE_STRING:
            $isValid = is_string($value);
            break;
        default:
            $isValid = false;
        }

        return $isValid;
    }

    /**
     * @api
     * @since 1.0.0
     *
     * @return string
     */
    public function __toString()
    {
        return $this->label;
    }
}

