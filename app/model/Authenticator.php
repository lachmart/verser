<?php

namespace Lab;

use Nette\Security;
use Nette\Security as NS;

/**
 * Users authenticator.
 */
class Authenticator extends \Nette\Object implements Security\IAuthenticator {

	/** @var Nette\Database\Connection */
	private $database;

	/** @var \Lab\LabUser */
	private $userModel;

	public function __construct(\DibiConnection $db, \Lab\LabUser $userModel) {
		$this->database = $db;
		$this->userModel = $userModel;
	}

	/**
	 * Performs an authentication.
	 * @return Nette\Security\Identity
	 * @throws Nette\Security\AuthenticationException
	 */
	public function authenticate(array $credentials) {

		list($username, $password) = $credentials;
		$user = $this->userModel->findByUsername($username);

		if (!$user) {
			throw new NS\AuthenticationException('Neplatné přihlašovací jméno, nebo heslo.');
		}

		if (!$user->ID) {
			throw new NS\AuthenticationException('Neplatné přihlašovací jméno, nebo heslo.');
		}

		if ($user->IS_DELETED) {
			throw new NS\AuthenticationException('Neplatné přihlášení. Pravděpodobně je profil smazaný, nebo neaktivní.');
		}

		if ($username != $user->LOGIN || sha1($password . $user->SALT) != $user->PASS) {
			throw new NS\AuthenticationException('Neplatné přihlašovací údaje.');
		}

		$data = [
			'name' => $user->NAME,
//			'email' => $user->getEmail(),
			'login' => $user->LOGIN,
			'lab' => explode(',', $user->LAB),
//			'accessLevel' => $user->getAccessLevel()
		];

		return new NS\Identity($user->ID, $user->LOGIN, $data);
	}

}
