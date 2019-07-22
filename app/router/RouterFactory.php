<?php

namespace Lab;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory {

	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter() {
		$router = new RouteList;

		$admin = new RouteList('Admin');
//		$admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Version:default');
		$admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Version:default');
		$admin[] = new Route('admin/<presenter>/<action>[/<id>/<vid>]', 'Version:versionList');                       		
		$router[] = $admin;

		$public = new RouteList('Front');

		$public[] = new Route('detail/[<id>]', 'Homepage:detail');

		$public[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router[] = $public;

		return $router;
	}

}
