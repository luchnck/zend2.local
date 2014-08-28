<?php
namespace Barcervice\Form;

use Zend\Form\Form;
use Barcervice\Form\Fieldset\CabFieldset;

class BarcerviceForm extends Form
{
	public function __construct()
	{
		parent::__construct('Barcervice');
		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'Go',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Go',
				'id' => 'submitbutton',
				),
			));

		$this->add(array(
			'type' => 'Barcervice\Form\Fieldsets\CabFieldset',
			'name' => 'CabFieldset',
			'options' => array(
				'label' => 'Cable parameters',
				'use_as_base_fieldset' => true,
				),
			));

		$this->add(array(
			'type' => 'Barcervice\Form\Fieldsets\BarFieldset',
			'name' => 'BarFieldset',
			));
			
		$this->setValidationGroup(array(
            'CabFieldset' => array(
                'name',
                'params',
                'amount',
				)
            ));
	}
	
	
}