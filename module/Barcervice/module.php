<?php
namespace Barcervice;

use Zend\Db\Sql\Sql;

class Module
{
	public function getAutoloaderConfig()
	{
	return array(
		'Zend\Loader\ClassMapAutoLoader' => array(
			__DIR__.'\autoload_classmap.php',
			),
		'Zend\Loader\StandardAutoloader' => array(
			'namespaces' => array(
				__NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,),
			),
		);
	}
	
	public function getConfig()
	{
	return include __DIR__.'/config/module.config.php';
	}
	
	public function getServiceConfig()
	{
	return array(
			'factories' => array(
				'BarcerviceModelBarcerviceSql' => function($sm){
					$sqlGateway = $sm->get('BarcerviceSQLService');
					$sql = new Model\BarcerviceSql($sqlGateway);
					return $sql;
					},
				'BarcerviceSQLService' => function($sm){
					$dbAdapter = $sm->get('ZendDbAdapterAdapterBarcervice');
					//$resultSetPrototype = new ResultSet();
					//$resultSetPrototype->setArrayObjectPrototype(new Barcervice());
					//return new TableGateway('barcervice',$dbAdapter, null, $resultSetPrototype);
					return new Sql($dbAdapter);
					}
				),
		);
	}
}