<?php
namespace DataTable;

class Column
{
    const
        TYPE_BOOLEAN = 'boolean',
        TYPE_DATE = 'date',
        TYPE_DATETIME = 'datetime',
        TYPE_NUMBER = 'number',
        TYPE_STRING = 'string';

    public static
        $types = [
            self::TYPE_BOOLEAN,
            self::TYPE_DATE,
            self::TYPE_DATETIME,
            self::TYPE_NUMBER,
            self::TYPE_STRING,
        ];

    private
        $label,
        $type;

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

    public function getId()
    {
        return $this->label . $this->type;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getType()
    {
        return $this->type;
    }

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

    public function __toString()
    {
        return $this->label;
    }
}

