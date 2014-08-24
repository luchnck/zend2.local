<?
namespace Barcervice\Model;

use Zend\Db\Sql\Sql;

class BarcerviceSql
{
	/*
	������ �������� sql
	*/
	protected $sql;
	
	public function __construct($source)
	{
		$this->sql = $source;
	}
	
	/*
	��������� ��������� ������������� ������ 
	@$input ������ ���������� ����� - �������� ����� �� ������� ��������� �������
	@array([name] => ��� ������, [params] => �����������)
	@return ������ ���������� ����������� ���� �� �� ���� null;
	*/
	public function getCableParams($input)
	{
	if (isset($input['name'])&&isset($input['params']))
		{	
		$select = $this->sql->select()
					->columns(array('diameter','weight'))
					->from($this->sql
								->select
								->columns('table_with_marko')
								->from('cable_types')
								->where(array('name' => $input['name'])))
					->where(array('params' => $input['params']));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		return $statement->execute();
		}
	else return null;
	}
	
	/*
	�������� ��� �������� ����� �������
	@return array([name] => value)
	*/
	public function getAllCableTypes()
	{
	/*$statement = $this->sql->getAdapter()->query('SELECT * FROM `cable_types`');
	$result = $statement->execute();*/
	$select = $this->sql->select()->columns(array('name'))->from('cable_types');
	$statement = $this->sql->prepareStatementForSqlObject($select);
	$result = $statement->execute();
	$i = 0;
	while ($result->current())
		{
			$array[$i] = $result->current()['name'];
			$result->next();
			$i++;
		}
	return $array;
	}
}