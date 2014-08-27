<?
namespace Barcervice\Model;

use Zend\Db\Sql\Sql;

class BarcerviceSql
{
	/*
	Объект драйвера sql
	*/
	protected $sql;
	
	public function __construct(Sql $source)
	{
		$this->sql = $source;
	}
	
	/*
	Извлекаем параметры интересующего кабеля 
	@$input массив содержащий ключи - значения полей бд которые требуется извлечь
	@array([name] => тип кабеля, [params] => маркоразмер)
	@return массив содержащий строку из бд либо null;
	*/
	public function getCableParams($input)
	{
	if (isset($input['name'])&&isset($input['params']))
		{	
		$select = $this->sql->select()
					->columns(array('diameter','weight'))
					->from($this->sql
								->select()
								->columns(array('table_with_marko'))
								->from('cable_types')
								->where(array('name' => $input['name'])))
					->where(array('params' => $input['params']));
		$result = $this->sql->prepareStatementForSqlObject($select)->execute();
		$array = $result->current();
		return $array;
		}
	else return null;
	}
	
	/*
	Получаем все значения типов кабелей
	@return array([name] => value)
	*/
	public function getAllCableTypes()
	{
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