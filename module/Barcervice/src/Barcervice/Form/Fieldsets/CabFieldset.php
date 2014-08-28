<?php
namespace Barcervice\Form\Fieldsets;

use Zend\Form\Fieldset;

/*
 ласс, отвечающий за элементы формы касающиес¤ параметров кабел¤
*/
class CabFieldset extends Fieldset
{
	public function __construct()
	{
		parent::__construct('CabFieldset');
		$this->add(array(
			'name' => 'name',
			'type' => 'Zend\Form\Element\Select',
			'required' => true,
			'attributes' =>array(
				'onChange' => 'submit();'
			),
			'options' => array(
				'label' => 'Select a type of cable:',
				'value_options' => array(
					'empty_option' => 'Need a load information',
					),
				),
			));
		$this->add(array(
			'name' => 'params',
			'required' => false,
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select a concrete position',
				'value_options' => array(
					'empty_option' => 'Select a type first',
					),
				),
			'attributes' =>array(
				'onChange' => 'submit();'
				),
			));
		$this->add(array(
			'name' => 'amount',
			'required' => false,
			'attributes' => array(
				'type' => 'text',
				),
			'options' => array(
				'label' => 'Set interesting amount, km',
				),
			));
	}
}