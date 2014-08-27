<?php
namespace Barcervice\TestModel;

use Barcervice\Model\BarcerviceSql;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Driver\Pdo\Statement;
use Zend\Db\Adapter\Driver\Pdo\Result;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class BarcerviceSqlTest extends PHPUnit_Framework_TestCase
{
	/*
	План тестирования:
	1 getCableParams($table) - проверяем спомощью mock объекта SQLMock правильность возвращаемого результата его тип
	2 getAllCableTypes()
	3 
	*/

	public function testGetMocksForWork()
	{
	return array(	'namesFromCableTypes' =>array(
											array('name'=>'Первый'),
											array('name' => 'Второй'),
											array('name' => 'Третий'),
												),				
				);
	}
	
	/**
	*@depends testGetMocksForWork
	*/
	public function provider($input)
	{
	//представление результата запроса из БД
	return $input;
	}
	
	/**
	* @depends testGetMocksForWork
	*/
	public function testgetCableParamsReturnsRightResults($input)
	{
		//Чучело сформированного запроса
		$statementInterface = $statementInterface = $this->getMock('Zend\Db\Adapter\Driver\Pdo\Statement', array('execute'), array(), '', false);
		//Чучело select'a и его поведение
		$select = $this->getMock('Zend\Db\Sql\Select', array('from', 'columns', 'where'), array(), '', false);
		//Чучело sql шлюза и его поведение
		$sqlMock = $this->getMock('Zend\Db\Sql\Sql', array('select', 'prepareStatementForSqlObject'), array(), '', false);
		
		//Подмены для подготовки результата
		
		$result = $this->getMock('Zend\Db\ResultSet\ResultSet', array('current'),array(),'',false);
		$result->expects($this->once())->method('current')->will($this->returnValue($result));
		$statementInterface->expects($this->once())->method('execute')->will($this->returnValue($result));
		
		$select->expects($this->any())->method('columns')->with($this->isType('array'))->will($this->returnValue($select));
		$select->expects($this->any())->method('from')->will($this->returnValue($select));
		$select->expects($this->any())->method('where')
								->with($this->logicalOr($this->arrayHasKey('name'),$this->arrayHasKey('params')))->will($this->returnValue($select));
		
		//подмены для sql шлюза
		$sqlMock->expects($this->any())->method('select')->will($this->returnValue($select));
		$sqlMock->expects($this->once())->method('prepareStatementForSqlObject')
								->with($this->isInstanceOf('Zend\Db\Sql\Select'))->will($this->returnValue($statementInterface));
		
		$barcerviceSql = new BarcerviceSql($sqlMock);
		$this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $barcerviceSql->getCableParams(array('name' => 1, 'params' => 1)));
	}
	
	/**
	* @depends testGetMocksForWork
	*/
	public function testgetAllCableTypesReturnsRightResults($input)
	{
		//Чучело сформированного запроса
		$statementInterface = $statementInterface = $this->getMock('Zend\Db\Adapter\Driver\Pdo\Statement', array('execute'), array(), '', false);
		//Чучело select'a и его поведение
		$select = $this->getMock('Zend\Db\Sql\Select', array('from', 'columns', 'where'), array(), '', false);
		//Чучело sql шлюза и его поведение
		$sqlMock = $this->getMock('Zend\Db\Sql\Sql', array('select', 'prepareStatementForSqlObject'), array(), '', false);
		
		$select->expects($this->once())
								->method('columns')
								->with($this->contains('name'))
								->will($this->returnValue($select));
		$select->expects($this->once())
								->method('from')
								->with($this->equalTo('cable_types'))
								->will($this->returnValue($select));
		
		
		//чучело сформированного запроса
		$result = new ResultSet();
		$result->initialize($input['namesFromCableTypes']);
		$statementInterface->expects($this->once())->method('execute')->will($this->returnValue($result));
		
		//Чучело шлюза
		$sqlMock->expects($this->any())->method('select')->will($this->returnValue($select));
		$sqlMock->expects($this->once())->method('prepareStatementForSqlObject')
								->with($this->isInstanceOf('Zend\Db\Sql\Select'))->will($this->returnValue($statementInterface));
								
		$barcerviceSql = new BarcerviceSql($sqlMock);
		
		$this->assertEquals(array('Первый','Второй','Третий'), $barcerviceSql->getAllCableTypes());
	}
}
