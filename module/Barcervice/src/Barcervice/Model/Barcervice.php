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
	* Вычисляем табличные данные  на основе полученных
	* возвращаем массив строк: ключи - название элементов формы, значения - заполняемые данные
	*/
	public function renderData($input = array())
	{
		$this->input = $input;
		$cableTypes = $this->getAllCableTypes();
		$spoolTypes = $this->getAllBarTypes();
		$array['bar_type'] = $spoolTypes;
		$array['name'] = $cableTypes['types'];
		$array['byAllBarTypes'] = 'No';
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
		if (array_key_exists('amount', $input))
			$array['dimensions']['totalWeight'] = $array['dimensions']['weight']*$input['amount'];
		if (array_key_exists('byAllBarTypes', $input))
			$array['byAllBarTypes'] = $input['byAllBarTypes'];
		return $array;
	}
}