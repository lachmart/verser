<?php

namespace Krecek5;


/**
 * Description of Config
 *
 * @author Petr
 */
class Config {

	/** @var */
	private $params = null;

	/**
	 *
	 * @param \Nette\DI\Container $container
	 */
	public function __construct(\Nette\DI\Container $container) {
		$this->params = $container->getParameters();
	}

	/**
	 *
	 * @return array
	 */
	public function getParams() {
		return $this->params;
	}

}
