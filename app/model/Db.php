<?php

/**
 * Description of Db
 *
 * @author Petr
 */
class Db
{

	/**
	 * @var \DibiConnection
	 */
	protected $db;

	/**
	 *
	 * @param \DibiConnection $db
	 * @param Nette\Http\Session $sess
	 */
	public function __construct(\DibiConnection $db)
	{
		$this->db = $db;
	}

	public function getDb()
	{
		return $this->db;
	}

}
