<?php

namespace Lab\FrontModule\Presenters;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

	/** @var \Dibi\Connection */
	protected $connection;

	function startup() {
		parent::startup();

		$this->connection = $this->context->getService('dibi.connection');

		try {
			$this->connection->connect();
		}
		catch (\Exception $e) {
//			dump('Exc');
//			dump($e);
		}
	}

}
