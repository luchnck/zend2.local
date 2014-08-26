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
	/*
	Контроллер по умолчанию должен выводить форму выбора параметров кабеля
	*/
	public function indexAction()
	{
	$this->initialise();
	$answer = $this->model->getAllCableTypes();
	$form = new BarcerviceForm();
	$dimensions = array();
	$form->get('CabFieldset')
		->get('name')
		->setValueOptions($answer['types']);
	//проверка заполнения поля типа
	$response = $this->getRequest()->getPost()->get('CabFieldset',null);
	if ($response != null){
		$form->get('CabFieldset')
			->get('name')
			->setOptions(array(
				'empty_option' => $answer['types'][$response['name']]
				));
		$marko = $this->model->getMarko($answer['ref_tables'][$response['name']]);
		$form->get('CabFieldset')
			->get('params')
			->setValueOptions($marko);
			//проверка заполнения поля маркоразмера
			if ($response['params'] != null){
			$dimensions = getCableDims($response['params'],$answer['ref_tables'][$response['name']]);
			}
		}
		else
		$form->get('CabFieldset')
			->get('name')
			->setOptions(array(
				'empty_option' => '',
				));
	return array('form' => $form, 'dimensions' => $dimensions);
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
	
	/*
	Действие отображающее ответ на введенные данные
	*/
	/*public function screening()
	{
	$model = new Barcervice();
	$sql = $this->getSQLGateway();
	$model->setSQLDriver($sql);
	$model->getCableParams(array(
							'name' => 'Кабели городские телефонные c полиэтиленовой изоляцией (ТППэп)',
							'params' => '5х2х0.4',
							));
	$weight = $model->getWeight();
	$diameter = $model->getDiameter();
	}*/
	
	public function getSQLGateway()
	{
		if (!$this->sqlGateway){
			$sm = $this->getServiceLocator();
			$this->sqlGateway = $sm->get('Barcervice\Model\BarcerviceSql');
			}
		return $this->sqlGateway;
	}
}