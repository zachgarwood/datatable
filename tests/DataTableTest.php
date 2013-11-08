<?php
class DataTableTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dataTable = new DataTable\Data;
    }

    public function testExceptionOnDuplicatColumns()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column(
            DataTable\Column::TYPE_BOOLEAN,
            'test'
        );
        $this->dataTable->addColumn($column);
        $this->dataTable->addColumn($column);
    }

    public function testAddColumn()
    {
        $beforeCount = count($this->dataTable->getColumns());

        $column = new DataTable\Column(
            DataTable\Column::TYPE_BOOLEAN,
            'test'
        );
        $this->dataTable->addColumn($column);

        $afterCount = count($this->dataTable->getColumns());

        $this->assertEquals($beforeCount + 1, $afterCount);
    }

    public function testExceptionOnInvalidColumnType()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column(
            'invalid column type',
            'test'
        );
    }

    public function testColumnToStringReturnsLabel()
    {
        $label = 'test';
        $column = new DataTable\Column(
            DataTable\Column::TYPE_BOOLEAN,
            $label
        );

        $this->assertEquals((string)$column, $column->getLabel());
    }

    public function testInsertRow()
    {
        $this->dataTable->insertRow(new DataTable\Row);

        $this->assertEquals(count($this->dataTable->getRows()), 1);
    }

    public function testSetCellWithSameColumnTypeOverridesPreviousCell()
    {
        $column = new DataTable\Column(
            DataTable\Column::TYPE_BOOLEAN,
            'test'
        );
        $cell1 = new DataTable\Cell($column, true);
        $cell2 = new DataTable\Cell($column, true);

        $row = new DataTable\Row;
        $row->setCell($cell1);
        $row->setCell($cell2);

        $this->assertNotSame(reset($row->getCells()), $cell1);
        $this->assertSame(reset($row->getCells()), $cell2);

    }
}

