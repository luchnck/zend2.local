<?
namespace Barcervice\Model;

use Zend\Db\Sql\Sql;

class BarcerviceSql
{
	/*
	Объект драйвера sql
	*/
	protected $sql;
	
	public function __construct($source)
	{
		$this->sql = $source;
	}
	
	/*
	Извлекаем параметры интересующего кабеля 
	@$input массив содержащий ключи - значения полей бд которые требуется извлечь
	@array([name] => тип кабеля, [params] => маркоразмер)
	@return массив содержащий извлеченные поля из бд либо null;
	*/
	public function getCableParams($input)
	{
	if (isset($input['ref_table'])&&isset($input['params']))
		{	
		$select = $this->sql->select()
					->columns(array('diameter','weight'))
					->from($input['ref_table'])
					->where(array('params' => $input['params']));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		return $statement->execute()->current();
		}
	else 
		return null;
	}
	
	/*
	Получаем все значения типов кабелей
	@return array([name] => value)
	*/
	public function getAllCableTypes()
	{
	$select = $this->sql->select()->columns(array('name','table_with_marko'))->from('cable_types');
	$statement = $this->sql->prepareStatementForSqlObject($select);
	$result = $statement->execute();
	$i = 0;
	while ($result->current())
		{
			$array[$i] = $result->current()['name'];
			$tables[$i] = $result->current()['table_with_marko'];
			$result->next();
			$i++;
		}
	return array('types' => $array, 'ref_tables' => $tables);
	}

	/*
	Получаем таблицу соотв типа кабеля
	*/
	public function getMarko($table)
	{
	$select = $this->sql->select($table)->columns(array('params'));
	$statement = $this->sql->prepareStatementForSqlObject($select);
	$result = $statement->execute();
	$i = 0;
	while ($result->current()){
		$array[] = $result->current()['params'];
		$result->next();
		}
	return $array;
	}
}