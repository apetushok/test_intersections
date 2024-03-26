<?php

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase {

	protected $router;

	protected function setUp(): void
	{
		$this->router = new App\Router();
	}

	public function testAddRoute() {
		$testFn = function(){ return 'test'; };
		$this->router->addRoute('GET', '/users', $testFn);

		$routes = $this->router->getRoutes();

		$this->assertCount(1, $routes);
		$this->assertEquals($testFn, $routes['GET']['/users']);
	}

	public function testDispatchValidRoute() {
		$testFn = function(){ echo 'User index page'; };
		$this->router->addRoute('GET', '/users', $testFn);

		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_SERVER['REQUEST_URI'] = '/users';

		ob_start();
		$this->router->dispatch( $_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'] );
		$output = ob_get_clean();

		$this->assertEquals('User index page', $output);
	}

	public function testDispatchInvalidRoute()
	{
		$_SERVER['REQUEST_METHOD'] = 'GET';
		$_SERVER['REQUEST_URI'] = '/non-existent-route';

		ob_start();
		$this->router->dispatch( $_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI'] );
		$output = ob_get_clean();

		$this->assertEquals('Page not found', $output);
	}
}
