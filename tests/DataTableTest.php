<?php
namespace DataTable;

class DataTableTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dataTable = new Table;
    }

    public function testExceptionOnColumnLabelNotString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new Column(Column::TYPE_BOOLEAN, null);
    }

    public function testExceptionOnDuplicatColumns()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new Column(Column::TYPE_BOOLEAN, 'test');
        $this->dataTable->addColumn($column);
        $this->dataTable->addColumn($column);
    }

    public function testAddColumn()
    {
        $beforeCount = count($this->dataTable->getColumns());
        $this->assertEquals($beforeCount, 0);

        $column = new Column(Column::TYPE_BOOLEAN, 'test');
        $this->dataTable->addColumn($column);
        $afterCount = count($this->dataTable->getColumns());
        $this->assertEquals($beforeCount + 1, $afterCount);

        $columns = $this->dataTable->getColumns();
        $this->assertSame($column, reset($columns));
    }

    public function testFindColumn()
    {
        $this->assertFalse($this->dataTable->findColumn('NOT A REAL LABEL'));

        $label = 'TEST LABEL';
        $column = new Column(Column::TYPE_STRING, $label);
        $this->dataTable->addColumn($column);
        $this->assertSame($column, $this->dataTable->findColumn($label));
    }

    public function testColumnIdIsConcatenatedLabelAndType()
    {
        $type = Column::TYPE_STRING;
        $label = 'LABEL';
        $column = new Column($type, $label);
        $this->assertSame($label . $type, $column->getId());
    }

    public function testExceptionOnInvalidColumnType()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new Column('invalid column type', 'test');
    }

    public function testColumnToStringReturnsLabel()
    {
        $label = 'test';
        $column = new Column(Column::TYPE_BOOLEAN, $label);

        $this->assertEquals((string)$column, $column->getLabel());
    }

    public function testInsertRowWithRowObject()
    {
        $this->dataTable->insertRow(new Row);

        $this->assertEquals(count($this->dataTable->getRows()), 1);
    }

    public function testInsertRowWithArrayOfCellObjects()
    {
        $cells = [
            new Cell(new Column(Column::TYPE_BOOLEAN, 'col1'), true),
            new Cell(new Column(Column::TYPE_STRING, 'col2'), 'string'),
        ];
        $this->dataTable->insertRow($cells);
        $this->assertEquals(count($this->dataTable->getRows()), 1);
    }

    public function testExceptionOnInsertRowWithInvalidArgument()
    {
        $this->dataTable->insertRow(new Row);
        $this->dataTable->insertRow(array());
        $this->setExpectedException('InvalidArgumentException');
        $this->dataTable->insertRow(null);
    }

    public function testExceptionOnCellLabelNotString()
    {
        $this->setExpectedException('InvalidArgumentException');
        $column = new Column(Column::TYPE_BOOLEAN, 'test');
        $cell = new Cell($column, true, null);
    }

    public function testSetCellWithSameColumnTypeOverridesPreviousCell()
    {
        $column = new Column(Column::TYPE_BOOLEAN, 'test');
        $cell1 = new Cell($column, true);
        $cell2 = new Cell($column, true);
        $row = new Row;
        $row->setCell($cell1);
        $row->setCell($cell2);

        $cells = $row->getCells();
        $this->assertNotSame(reset($cells), $cell1);
        $this->assertSame(reset($cells), $cell2);
    }

    /**
     * @dataProvider provideColumnsOfEachDataType
     */
    public function testExceptionOnCellValueColumnTypeMismatch(Column $column)
    {
        $this->setExpectedException('InvalidArgumentException');
        $cell = new Cell($column, null);
    }

    public function provideColumnsOfEachDataType()
    {
        $columns = array();
        foreach (Column::$types as $type) {
            $columns []= [new Column($type, 'test')];
        }

        return $columns;
    }
}

