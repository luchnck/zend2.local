<?
namespace Barcervice\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Barcervice\Model\Barcervice;
use Barcervice\Form\BarcerviceForm;

class BarcerviceController extends AbstractActionController
{
	protected $sqlGateway;
	
	/*
	���������� �� ��������� ������ �������� ����� ������ ���������� ������
	*/
	public function indexAction()
	{
	$form = new BarcerviceForm();
		return array('form' => $form);
	}
	
	/*
	�������� ������������ ����� �� ��������� ������
	*/
	/*public function screening()
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