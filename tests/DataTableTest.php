<?php
class DataTableTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dataTable = new DataTable\Table;
    }

    public function testExceptionOnColumnLabelNotString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, null);
    }

    public function testExceptionOnDuplicatColumns()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, 'test');
        $this->dataTable->addColumn($column);
        $this->dataTable->addColumn($column);
    }

    public function testAddColumn()
    {
        $beforeCount = count($this->dataTable->getColumns());
        $this->assertEquals($beforeCount, 0);

        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, 'test');
        $this->dataTable->addColumn($column);
        $afterCount = count($this->dataTable->getColumns());
        $this->assertEquals($beforeCount + 1, $afterCount);

        $firstColumn = reset($this->dataTable->getColumns());
        $this->assertSame($column, $firstColumn);
    }

    public function testFindColumn()
    {
        $this->assertNull($this->dataTable->findColumn('NOT A REAL LABEL'));

        $label = 'TEST LABEL';
        $column = new DataTable\Column(DataTable\Column::TYPE_STRING, $label);
        $this->dataTable->addColumn($column);
        $this->assertSame($column, $this->dataTable->findColumn($label));
    }

    public function testExceptionOnInvalidColumnType()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column('invalid column type', 'test');
    }

    public function testColumnToStringReturnsLabel()
    {
        $label = 'test';
        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, $label);

        $this->assertEquals((string)$column, $column->getLabel());
    }

    public function testInsertRow()
    {
        $this->dataTable->insertRow(new DataTable\Row);

        $this->assertEquals(count($this->dataTable->getRows()), 1);
    }

    public function testExceptionOnCellLabelNotString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, 'test');
        $cell = new DataTable\Cell($column, true, null);
    }

    public function testSetCellWithSameColumnTypeOverridesPreviousCell()
    {
        $column = new DataTable\Column(DataTable\Column::TYPE_BOOLEAN, 'test');
        $cell1 = new DataTable\Cell($column, true);
        $cell2 = new DataTable\Cell($column, true);
        $row = new DataTable\Row;
        $row->setCell($cell1);
        $row->setCell($cell2);

        $firstCell = reset($row->getCells());
        $this->assertNotSame($firstCell, $cell1);
        $this->assertSame($firstCell, $cell2);
    }

    public function testExceptionOnCellValueColumnTypeMismatch()
    {
        foreach (DataTable\Column::$types as $type) {
            $this->setExpectedException('InvalidArgumentException');
            $column = new DataTable\Column($type, 'test');
            $cell = new DataTable\Cell($column, null);
        }
    }
}

