<?php
namespace Barcervice\Form\Fieldsets;

use Zend\Form\Fieldset;

/*
 Класс, отвечающий за элементы формы касающиеся параметров барабанов
*/
class BarFieldset extends Fieldset
{
	public function __construct()
	{
		parent::__construct('BarFieldset');
		$this->add(array(
			'name' => 'bar_type',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select a type of spool',
				'value_options' => array(
					'0' => 'default',
					),
				),
			));
		$this->add(array(
			'name' => 'byAllBarTypes',
			'type' => 'Zend\Form\Element\CheckBox',
			'options' => array(
				'label' => 'Need info about all types of spool???',
				'checked_value' => 'Yes',
				'unchecked_value' => 'No',
				'use_hidden_Element' => false,
				),
			));
	}
}