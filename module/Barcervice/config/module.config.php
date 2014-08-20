<?
return array(
	'controllers' => array(
		'invokables' => array(
			'Barcervice\Controller\Barcervice' => 'Barcervice\Controller\BarcerviceController',
			),
	),
	'view_manager' => array(
		'template_path_stack' => array(
		'barcervice' => __DIR__ . '/../view',
			),
	),
	'router' => array(
		'routes' => array(
			'barcervice' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/barcervice[/:action]',
					'constrains' => array(
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
						),
					'defaults' => array(
						'controller' => 'Barcervice\Controller\Barcervice',
						'action' => 'index',
						),
					),
			),
		),
	),
);