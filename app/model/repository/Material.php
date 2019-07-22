<?php

namespace Krecek\Repository;

/**
 * Description of Material
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Material {

	/** @var \DibiConnection */
	private $db;

	function __construct(\DibiConnection $db) {
		$this->db = $db;
	}

	function getList() {
		return $this->db->select('ID, KLIC, N32')
						->from('nclp_nclpmat_c')
						->where('RACT=\'A\'')
						->orderBy('N32')
						->fetchAll()
		;
	}

}
