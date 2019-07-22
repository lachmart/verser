<?php

namespace Krecek\Repository;

/**
 * Description of Normaly
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Normaly {

	const TABLE = 'normaly';

	/** @var \DibiConnection */
	private $db;

	function __construct(\DibiConnection $db) {
		$this->db = $db;
	}

	function getReferableValue($lab, $masterId) {

		$q = "SELECT SEX,VEK_OD,VEK_DO,PATOL_OD,NIZKA_OD,SNIZENA_OD,NORMAL_OD,NORMAL_DO,SNIZENA_DO,NIZKA_DO,PATOL_DO "
			. "FROM normaly "
			. "WHERE RACT='A'" .
//			" AND LAB='" . $lab . "' AND MASTER_ID=" . $masterId;
			" AND MASTER_ID=" . $masterId;
		$q .= " ORDER BY VEK_OD ASC";

		return $this->db->query($q)->fetchAll();
	}

}
