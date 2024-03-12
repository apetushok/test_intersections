<?php

namespace App;

class Router
{
	private $routes = [];

	public function addRoute( string $method, string $path, callable $callback ): void {
		$this->routes[ $method ][ $path ] = $callback;
	}

	public function dispatch( string $method, string $path ): void {
		$path = rtrim( $path, '/' );
		if ( isset( $this->routes[ $method ][ $path ] ) ) {
			$callback = $this->routes[ $method ][ $path ];
			if ( is_callable( $callback ) ) {
				call_user_func( $callback );
				return;
			}
		}

		http_response_code(404);
		echo 'Page not found';
	}

	public function getRoutes(): array {
		return $this->routes;
	}
}