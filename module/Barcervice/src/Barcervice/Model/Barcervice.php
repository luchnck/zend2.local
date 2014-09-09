<?
namespace Barcervice\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Barcervice implements InputFilterAwareInterface
{
	public $diameter;
	public $weight;
	public $totalWeight;
	public $input;
	protected $sql;
	protected $inputFilter;
	
	public function __construct()
	{
		$this->input = array();
	}
	
	/**
	* Изменение фильтра запрещено
	*/
	public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new Exception("Not used");
    }
	
	/**
	* Инициализация входного фильтра
	*/
	public function getInputFilter()
	{
		if (!$this->inputFilter)
		{
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			
			if (array_key_exists('name',$this->input))
			$inputFilter->add($factory->createInput(array(
				'name' => 'name',
				'required' => true,
				'filters' => array(
					array('name' => 'Digits'),
					)
				)
			));
			
			if (array_key_exists('params',$this->input))
			$inputFilter->add($factory->createInput(array(
				'name' => 'params',
				'filters' => array(
					array('name' => 'Digits'),
					),
				/*'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
							'encoding' => 'UTF-8',
							'min' => 1,
							'max' => 100,
							)
						)
					),*/
				)
			));
			
			if (array_key_exists('amount',$this->input))
			$inputFilter->add($factory->createInput(array(
				'name' => 'amount',
				'filters' => array(
							array('name' => 'Int'),
							),
				)
			));
			
			if (array_key_exists('bar_type',$this->input))
			$inputFilter->add($factory->createInput(array(
				'name' => 'bar_type',
				'filters' => array(
							array('name' => 'Digits'),
							),
				)
			));
		$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}
	
	/**
	* Инициализируем драйвер к базе данных
	* $sqlSource - объект драйвера бд, отвечает за получение сведений при использовании конкретных методов
	*/
	public function setSQLDriver($sqlSource)
	{
		$this->sql = $sqlSource;
	}
	
	/**
	*Функция загрузки данных в объект через массив $data
	*$data содержит поля [diameter] [weight]
	*/
	public function exchangeArray($data)
	{
		$this->diameter = (isset($data['diameter'])) ? $data['diameter']:null;
		$this->weight = (isset($data['weight'])) ? $data['weight']:null;
	}
	
	/**
	* Получить параметры кабеля
	* @$input - массив с полями 
	*			params - макреоразмер кабеля и 
	*			ref_table - название таблицы в которой лежат данные
	* @заполняет внутренние поля объекта полученными данными diameter и weight
	*/
	public function getCableParams($input)
	{
		return $this->sql->getCableParams($input);
	}
	
	/**
	*Получить весь список типов кабеля
	*Возвращает массив типа 
	*[1] => array(
	*			[label] => label
	*			[value] => value
	*			)
	*[empty_option] => array(
	*			[label]	=> empty_label
	*			)
	*/
	public function getAllCableTypes()
	{
		return $this->sql->getAllCableTypes();
	}
	
	/*
	Получить маркоразмеры для данного типа 
	Принимает $table таблицу из которой извлекаются записи
	Возвращает массив записей с полями 
	[label] => label 
	[value] => value
	*/
	public function getMarko($table)
	{
		return $this->sql->getMarko($table);
	}
	
	/**
	*Рассчет веса кабеля по длине $input
	*Заполняет соответсвтующее поле объекта
	*/
	public function calculateWeight($input)
	{
		$this->totalWeight = $this->weight*$input;
	}
	
	/**
	* Рендерим выходные данные для представления
	*/
	public function renderDims()
	{
		if ($this->diameter != null)
		$array[] = array(
						'label' => "<div>Диаметр, мм - $this->diameter</div>",
						'value' => $this->diameter,
						);
		if ($this->weight != null)
		$array[] = array(
						'label' => "<div>Вес километра кабеля,кг - $this->weight</div>",
						'value' => $this->weight,
						);
		if ($this->totalWeight != null)
		$array[] = array(
						'label' => "<div>Общий вес запрошенного кабеля составит, кг - $this->totalWeight</div>",
						'value' => $this->totalWeight,
						);
		return $array;
	}
	
	/**
	* Функция получения списка доступных барабанов
	* возвращает результат в виде
	* [1] => array(
	*			[label] => label
	*			[value] => value
	*			)
	* [empty_option] => array(
	*			[label]	=> empty_label
	*			)
	*/
	public function getAllBarTypes()
	{
		return $this->sql->getAllBarTypes();
	}
	
	/**
	* Получение табличных данных по норме намотки
	* На входе: тип барабана, диаметр кабеля
	* На выходе: Число - норма намотки в метрах
	*/
	public function amountPerSpool($barType, $diameter)
	{
		return $this->sql->amountPerSpool($barType, $diameter);
	}
	
	/**
	* Вычисляем табличные данные  на основе полученных
	* возвращаем массив строк: ключи - название элементов формы, значения - заполняемые данные
	*
	*/
	public function renderData($input = array())
	{
		$this->input = $input;
		$cableTypes = $this->getAllCableTypes();
		$spoolTypes = $this->getAllBarTypes();
		
		$array['name'] = $cableTypes['types'];
		if (array_key_exists('name', $input))
			$array['params'] = $this->getMarko($cableTypes['ref_tables'][$input['name']]);
		if (array_key_exists('params', $input)){
			$array['dimensions'] = $this->getCableParams(array(
											'ref_table' => $cableTypes['ref_tables'][$input['name']], 
											'params' => $array['params'][$input['params']],
											)
										);
			$array['amount'] = '0';
			}
		if (array_key_exists('amount', $input)){
				$array['amount'] = $input['amount'];
				$array['dimensions']['totalWeight'] = ceil($array['dimensions']['weight']*$input['amount']/1000);
				$array['bar_type'] = $spoolTypes;
				$array['byAllBarTypes'] = 'No';
			}
		if (array_key_exists('byAllBarTypes', $input)){
				$array['byAllBarTypes'] = $input['byAllBarTypes'];
				if ($input['byAllBarTypes'] == 'No'){
					if (array_key_exists('bar_type', $input)){
						$array['dimensions']['bar_num'] = ceil(
									$array['amount'] / $this->amountPerSpool( 
												$spoolTypes[$input['bar_type']]['alias'], ceil($array['dimensions']['diameter'])
												)
									);
						$thatBar = $this->getBarInfo($spoolTypes[$input['bar_type']]['alias']);
						//var_dump($thatBar);
						$array['dimensions']['volume'] = $array['dimensions']['bar_num'] * $thatBar['volume'];
						$array['dimensions']['totalWeight'] = $array['dimensions']['totalWeight'] + $array['dimensions']['bar_num']*$thatBar['weight_w_armor'];
						}
					}
				else
					{
					//var_dump($spoolTypes);
					$i = 0;
					while (array_key_exists($i, $spoolTypes)){
						$array['dimensions'][$spoolTypes[$i]['label']]['bar_num'] = ceil(
									$array['amount'] / $this->amountPerSpool( 
												$spoolTypes[$i]['alias'], ceil($array['dimensions']['diameter'])
												)
									);
						$thatBar = $this->getBarInfo($spoolTypes[$i]['alias']);
						//var_dump($thatBar);
						$array['dimensions'][$spoolTypes[$i]['label']]['volume'] = $array['dimensions'][$spoolTypes[$i]['label']]['bar_num'] * $thatBar['volume'];
						$array['dimensions'][$spoolTypes[$i]['label']]['totalWeightArr'] = $array['dimensions']['totalWeight'] + $array['dimensions'][$spoolTypes[$i]['label']]['bar_num']*$thatBar['weight_w_armor'];
						$i++;
						}
					//var_dump($array['dimensions']);
					}
			}
		return $array;
	}
	
	public function getBarInfo($barType)
	{
		return $this->sql->getBarInfo($barType);
	}

	/**
	* Формируем заголовки из всех подмассивов входного массива
	* Отдаем в виде массива состоящего из заголовков
	*/
	public function getHeaders($array = array())
	{
		$result = array('bar_type',);
		if (is_array($array))
		foreach ($array as $key => $values)
			if (is_array($values)){
				foreach ($values as $name => $value)
					$result[] = $name;
				return $result;
			}
	}
}