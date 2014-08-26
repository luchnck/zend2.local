<?php
namespace Barcervice\Form\Fieldsets;

use Zend\Form\Fieldset;

/*
�����, ���������� �� �������� ����� ���������� ���������� ������
*/
class CabFieldset extends Fieldset
{
	public function __construct()
	{
		parent::__construct('CabFieldset');
		$this->add(array(
			'name' => 'name',
			'type' => 'Zend\Form\Element\Select',
			'attributes' =>array(
				'onChange' => 'submit();'
			),
			'options' => array(
				'label' => 'Select a type of cable:',
				'value_options' => array(
					'0' => 'default',
					),
				),
			));
		$this->add(array(
			'name' => 'params',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select a concrete position',
				'value_options' => array(
					'0' => 'default',
					),
				),
			'attributes' =>array(
				'onChange' => 'submit();'
				),
			));
		$this->add(array(
			'name' => 'amount',
			'attributes' => array(
				'type' => 'text',
				'onSelect' => 'alert(this.value);'
				),
			'options' => array(
				'label' => 'Set interesting amount',
				),
			));
	}
}