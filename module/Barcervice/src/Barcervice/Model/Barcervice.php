<?
namespace Barcervice\Model;

class Barcervice
{
	public $diameter;
	public $weight;
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
	if (isset($input['name']) && isset($input['params']))
		$this->exchangeArray($this->sql->getCableParams($input));
	}
	
	public function getAllCableTypes()
	{
		return $this->sql->getAllCableTypes();
	}
	
}