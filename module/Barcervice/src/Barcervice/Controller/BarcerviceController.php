<?
namespace Barcervice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Barcervice\Model\Barcervice;
use Barcervice\Form\BarcerviceForm;

class BarcerviceController extends AbstractActionController
{
	protected $sqlGateway;
	
	/*
	Контроллер по умолчанию должен выводить форму выбора параметров кабеля
	*/
	public function indexAction()
	{
	$form = new BarcerviceForm();
	$form->get('CabFieldset')->get('name')->setValueOptions(array('0' => 'Repaired','1' => 'Prepaired'));
	$form->get('CabFieldset')->get('name')->setOption('value_options',array('0' => 'Repaired','1' => 'Prepaired'));
	var_dump($form->get('CabFieldset')->get('name'));
	/**to do*
	Заполнить форму нужными значениями
	*/
		return array('form' => $form);
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