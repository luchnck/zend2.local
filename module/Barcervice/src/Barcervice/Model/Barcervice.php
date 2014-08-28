<?
namespace Barcervice\Model;

class Barcervice
{
	public $diameter;
	public $weight;
	public $totalWeight;
	protected $sql;
	
	/*
	Инициализируем драйвер к базе данных
	$sqlSource - объект драйвера бд, отвечает за получение сведений при использовании конкретных методов
	*/
	public function setSQLDriver($sqlSource)
	{
		$this->sql = $sqlSource;
	}
	
	/*
	Функция загрузки данных в объект через массив $data
	$data содержит поля [diameter] [weight]
	*/
	public function exchangeArray($data)
	{
		$this->diameter = (isset($data['diameter'])) ? $data['diameter']:null;
		$this->weight = (isset($data['weight'])) ? $data['weight']:null;
	}
	
	public function getCableParams($input)
	{
		$this->exchangeArray($this->sql->getCableParams($input));
	}
	
	public function getAllCableTypes()
	{
		return $this->sql->getAllCableTypes();
	}
	
	public function getMarko($table)
	{
		return $this->sql->getMarko($table);
	}
	
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
	
}