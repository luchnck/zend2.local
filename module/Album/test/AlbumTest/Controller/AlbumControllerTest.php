<?php
namespace Album\ControllerTest;

use Album\Controller\AlbumController;
use PHPUnit_Framework_TestCase;

class AlbumControllerTest extends PHPUnit_Framework_TestCase
{
	public function testGetAlbumTableReturnsAnInstanceOfAlbumTable()
	{
	$controller = new AlbumController();
	$this->assertInstanceOf('Album\Model\AlbumTable', $controller->getAlbumTable());
	}
}