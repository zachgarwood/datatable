<?php
namespace DataTable;

class Cell
{
    public
        $label,
        $value;

    private
        $column;

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

        return $this;
    }

    public function getColumn()
    {
        return $this->column;
    }
}

