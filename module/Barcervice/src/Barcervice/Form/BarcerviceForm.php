<?php
namespace Barcervice\Form;

use Zend\Form\Form;

class BarcerviceForm extends Form
{
	public function __construct($arguments)
	{
		parent::__construct('Barcervice');
		$this->setAttribute('method','post');

		if (array_key_exists('name',$arguments))
		$this->add(array(
			'name' => 'name',
			'type' => 'Zend\Form\Element\Select',
			'required' => true,
			'attributes' =>array(
				'onChange' => 'submit();'
			),
			'options' => array(
				'label' => 'Select a type of cable:',
				'value_options' => $arguments['name'],
				),
			));
		
		if (array_key_exists('params',$arguments))
		$this->add(array(
			'name' => 'params',
			'required' => false,
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select a concrete position',
				'value_options' => $arguments['params'],
				),
			'attributes' =>array(
				'onChange' => 'submit();'
				),
			));
		
		if (array_key_exists('amount', $arguments))
		$this->add(array(
			'name' => 'amount',
			'required' => false,
			'attributes' => array(
				'type' => 'text',
				),
			'options' => array(
				'label' => 'Set interesting amount, km',
				),
			'value' => $arguments['amount'],
			));

		if (array_key_exists('bar_type', $arguments))
		$this->add(array(
			'name' => 'bar_type',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'Select a type of spool',
				'value_options' => $arguments['bar_type'],
				),
			));
			
		if (array_key_exists('byAllBarTypes', $arguments))
		$this->add(array(
			'name' => 'byAllBarTypes',
			'type' => 'Zend\Form\Element\CheckBox',
			'options' => array(
				'label' => 'Need info about all types of spool???',
				'checked_value' => 'Yes',
				'unchecked_value' => 'No',
				'use_hidden_Element' => false,
				),
			'value' => $arguments['byAllBarTypes'],
			));
			
		$this->add(array(
			'name' => 'Go',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Go',
				'id' => 'submitbutton',
				),
			));
	}
	
	/**
	* ѕолучаем метаданные формы в виде массива
	* в $input строка инициализированных элементов 
	*/
	public function getMetaData()
	{
		$array['elements'] = $this->getElements();
		$fieldsets = $this->getFieldsets();
		$array['fieldsets'] = array();
		foreach ($fieldsets as $name => $object){
			$array['fieldsets'][$name]= $object->getElements();
			}
		return $array;	
	}
}