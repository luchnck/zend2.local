<?
namespace Barcervice\Model;

use Zend\Db\Sql\Sql;

class BarcerviceSql
{
	/**
	Объект драйвера sql
	*/
	protected $sql;
	
	public function __construct($source)
	{
		$this->sql = $source;
	}
	
	/**
	Извлекаем параметры интересующего кабеля 
	@$input массив содержащий ключи - значения полей бд которые требуется извлечь
	@ [params] => маркоразмер 
	  [ref_table] => таблица с данными	
	@return массив содержащий извлеченные поля из бд либо null;
	*/
	public function getCableParams($input)
	{
	if (isset($input['ref_table'])&&isset($input['params']))
		{
		$select = $this->sql->select()
					->columns(array('diameter','weight'))
					->from($input['ref_table'])
					->where( array( 'params' => $input['params']['label'] ));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		return $statement->execute()->current();
		}
	else 
		return null;
	}
	
	/**
	Получаем все значения типов кабелей
	@return array([name] => value)
	*/
	public function getAllCableTypes()
	{
	$select = $this->sql->select()
				->columns(array('name','table_with_marko'))
				->from('cable_types');
	$statement = $this->sql->prepareStatementForSqlObject($select);
	$result = $statement->execute();
	$array['empty_option'] = array(
					'label' => 'Select a type of cable',
					);
	$i = 0;
	while ($result->current())
		{
			$array[] = array(
							'label' => $result->current()['name'], 
							'value' => $i,
							);
			$tables[$i] = $result->current()['table_with_marko'];
			$result->next();
			$i++;
		}
	return array('types' => $array, 'ref_tables' => $tables);
	}

	/**
	Получаем таблицу соотв типа кабеля
	*/
	public function getMarko($table)
	{
	$select = $this->sql->select($table)->columns(array('params'));
	$statement = $this->sql->prepareStatementForSqlObject($select);
	$result = $statement->execute();
	$i = 0;
	$array['empty_option'] = array('label' => 'Select a parameters of cable');
	while ($result->current()){
		$array[] = array(
						'label' => $result->current()['params'], 
						'value' => $i++
						);
		$result->next();
		}
	return $array;
	}

	/**
	* Получаем список барабанов
	*/
	public function getAllBarTypes()
	{
		$select = $this->sql->select()
					->columns(array('type','alias'))
					->from('baraban_types');
		$statement = $this->sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		$array['empty_option'] = array(
						'label' => 'Select a type of baraban',
						);
		$i = 0;
		while ($result->current())
			{
				$array[] = array(
								'label' => $result->current()['type'], 
								'value' => $i,
								'alias' => $result->current()['alias'],
								);
				$result->next();
				$i++;
			}
		return $array;
	}

	/**
	* Получение нормы намотки кабеля
	*/
	public function amountPerSpool($barType, $diameter)
	{
		$select = $this->sql->select()
						->columns(array($barType))
						->from('namotka')
						->where(array('diameter' => $diameter));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		return $statement->execute()->current()[$barType];
	}
	
	/**
	* Принимает значение поля alias таблицы baraban_types
	* Возвращает массив строк [height][width][volume][weight_w_armor] соответствующего типа барабана
	*/
	public function getBarInfo($barType)
	{
		$select = $this->sql->select('baraban_types')
						->columns(array('height','width','volume','weight_w_armor'))
						->where(array('alias' => $barType));
		$statement = $this->sql->prepareStatementForSqlObject($select);
		return $statement->execute()->current();
	}
}