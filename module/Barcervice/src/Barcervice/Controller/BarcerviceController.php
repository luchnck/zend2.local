<?
namespace Barcervice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Barcervice\Model\Barcervice;
use Barcervice\Form\BarcerviceForm;

class BarcerviceController extends AbstractActionController
{
	protected $sqlGateway;
	protected $model;
	
	/*
	Конструктор класса контроллера с прикреплением модели и шлюза БД
	*/
	public function initialise()
	{
		
		$this->model = new Barcervice();
		$sql = $this->getSQLGateway();
		$this->model->setSQLDriver($sql);
	}
	
	public function validateInput($input)
	{
		$inputFilter = $this->model->getInputFilter();
		$inputFilter->setData($input);
		if ($inputFilter->isValid())
			return array('result' => true, 'messages' => '');
		else 
			return array('result' => false, 'messages' => $inputFilter->getMessages());
	}
	
	/*
	Контроллер по умолчанию должен выводить форму выбора параметров кабеля
	*/
	public function indexAction()
	{
	$this->initialise();
	$response = $this
				->getRequest()
				->getPost();
	//var_dump($response);
	//проверка наличия заполненных данных
	if ($response['name'] != null)
	{
		$validation = $this->validateInput($response);
		// если данные пришли в правильной форме
		if ($validation['result'])
		{
			// обрабатываем пришедшие данные
			$data = $this->model->renderData($response);
		}
	}
	else
		$data = $this->model->renderData();
	// создаем форму на основе этих данных
	$form = new BarcerviceForm($data);
	$form->setData($response);
	$headers = $this->model->getHeaders($data['dimensions']);
	return 
		array(
			'form' => $form, 
			'dimensions' => $data['dimensions'],
			'messages' => $validation['messages'],
			'headers' => $headers,
			); 
	}
	
	public function selectAction()
	{
	$this->initialise();
	$form = new BarcerviceForm();
	$answer = $this->model->getAllCableTypes();
	$form->get('CabFieldset')
		->get('name')
		->setValueOptions($answer['types']);
	}
	
	public function getSQLGateway()
	{
		if (!$this->sqlGateway){
			$sm = $this->getServiceLocator();
			$this->sqlGateway = $sm->get('Barcervice\Model\BarcerviceSql');
			}
		return $this->sqlGateway;
	}
}