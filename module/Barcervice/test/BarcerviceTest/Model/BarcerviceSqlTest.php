<?php
namespace Barcervice\TestModel;

use Barcervice\Model\BarcerviceSql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Driver\Pdo\Statement;
use Zend\Db\Adapter\Driver\Pdo\Result;
use PHPUnit_Framework_TestCase;

class BarcerviceSqlTest extends PHPUnit_Framework_TestCase
{
	/*
	План тестирования:
	1 getCableParams($table) - проверяем спомощью mock объекта SQLMock правильность возвращаемого результата
	2 getAllCableTypes()
	3 
	*/

	public function testgetCableParamsReturnsRightResults()
	{
		$select = new Select();
		$StatementInterface = new Statement();
		$sqlMock = $this->getMock('Zend\Db\Sql\Sql', array('select','from','columns','where'), array(),'', false);
		$sqlMock->expects($this->at(0))->method('select');
		$sqlMock->expects($this->at(1))->method('columns')->with(array('diameter','weight'));
		$sqlMock->expects($this->at(2))->method('from');
		$sqlMock->expects($this->at(3))->method('select');
		$sqlMock->expects($this->at(4))->method('columns');
		$sqlMock->expects($this->at(5))->method('from');
		$sqlMock->expects($this->at(6))->method('where')
								->with(array());
		$sqlMock->expects($this->at(7))->method('where')
								->with(array())->will($this->returnValue($select));
		$sqlMock->expects($this->at(8))->method('prepareStatementForSqlObject')
								->with($this->isType($select))->will($this->returnValue($StatementInterface));
		$sqlMock->process();
		
		$barcerviceSql = new BarcerviceSql($sqlMock);
		
		$this->assertInstanceOf('Zend\Db\Adapter\Driver\Pdo\Result', $barcerviceSql->getCableParams());
		
		
	}
}
