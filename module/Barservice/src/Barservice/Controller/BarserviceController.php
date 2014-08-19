<?
namespace Barcervice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Barcervice\Model\Barcervice;

class BarcerviceController extends AbstractActionController
{
	protected $sqlGateway;
	
	/*
	Контроллер по умолчанию должен выводить форму выбора параметров кабеля
	*/
	public function indexAction()
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
	}
	
	/*
	Действие отображающее ответ на введенные данные
	*/
	public function screening()
	{
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