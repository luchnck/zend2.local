<?php
namespace Barcervice\Form;

use Zend\Form\Form;

class BarcerviceForm extends Form
{
	public function __construct()
	{
		parent::__construct('Barcervice');
		$this->setAttribute('method','post');
		$this->add(array(
			'name' => 'name',
			'type' => 'Zend\Form\Element\Select',
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
			));
		$this->add(array(
			'name' => 'amount',
			'attributes' => array(
				'type' => 'text',
				),
			'options' => array(
				'label' => 'Set interesting amount',
				),
			));
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
		$this->add(array(
			'name' => 'submit',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Go',
				'id' => 'submitbutton',
				),
			));
	}
}