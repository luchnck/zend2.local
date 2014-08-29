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
	$barTypes = $this->model->getAllBarTypes();
	$form = new BarcerviceForm();
		$response = $this
					->getRequest()
					->getPost()
					->get('CabFieldset',null);	
					
		//проверка заполнения поля типа
		if ($response['name'] != null){
			$answer['types'][$response['name']]['selected'] = true;
			
			//получаем маркоразмеры для данного типа
			$marko = $this
					->model
					->getMarko($answer['ref_tables'][$response['name']]);
					
			//проверка заполнения поля маркоразмера
			if ($response['params'] != null){
				$marko[$response['params']]['selected'] = true;
				
				//получаем параметры конкретного вида кабеля
				$this->model->getCableParams(
											array( 
												'params' => $marko[$response['params']]['label'],
												'ref_table' => $answer['ref_tables'][$response['name']],
												)
											);
				
				//проверка заполнения поля количества
				if ($response['amount'] != null){
					$this->model->calculateWeight($response['amount']);
					
					// заполняем поле количества
					$form->get('CabFieldset')
							->get('amount')
							->setAttributes(array('value' => $response['amount']));
				} 
			else
				$marko['empty_option']['selected'] = true;
			}
			//Заполняем поле маркоразмеров
			$form->get('CabFieldset')
					->get('params')
					->setValueOptions($marko);
			
		}	
		//Заполняем поле типов кабеля с учетом выбранных значений
		$form->get('CabFieldset')
				->get('name')
				->setValueOptions($answer['types']);
		
		//Заполняем поле типов барабанов и устанавливаем указатель
		if ($response['bar_type'] != null)
			$barTypes[$response['bar_type']]['selected'] = true;
		else
			$barTypes['empty_option']['selected'] = true;
		$form->get('BarFieldset')
				->get('bar_type')
				->setValueOptions($barTypes);
		var_dump($form->getMetaData());
		return 
			array(
				'form' => $form, 
				'dimensions' => $this->model->renderDims(),
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
	
	/**
	* Действие отображающее ответ на введенные данные
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