<?
namespace Barcervice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Barcervice\Model\Barcervice;

class BarcerviceController extends AbstractActionController
{
	protected $sqlGateway;
	
	/*
	���������� �� ��������� ������ �������� ����� ������ ���������� ������
	*/
	public function indexAction()
	{
	$model = new Barcervice();
	$sql = $this->getSQLGateway();
	$model->setSQLDriver($sql);
	$model->getCableParams(array(
							'name' => '������ ��������� ���������� c �������������� ��������� (�����)',
							'params' => '5�2�0.4',
							));
	$weight = $model->getWeight();
	$diameter = $model->getDiameter();
	}
	
	/*
	�������� ������������ ����� �� ��������� ������
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