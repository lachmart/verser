<?php

namespace Version;

class Version
{
    const TABLE_SYSTEM = 'system_c';
    const TABLE_VERSION = 'version';
    const TABLE_VERSIONDATA = 'version_data';

    /** @var \DibiConnection */
	private $db;

    public function __construct(\Dibi\Connection $db) {
        $this->db = $db;
        //$this->user = $user;
    }

    function getListSystem() {
  		return $this->db->select('*')
            ->from(self::TABLE_SYSTEM)
  			->where('IS_DELETED = 0')
//            ->orderBy('ID desc')
  			->fetchAll();
  	}

    function getListVersion($sid) {
  		return $this->db->select('*')
            ->from(self::TABLE_VERSION)
  			->where('SYS_ID = ? and ACTIVE = 1',$sid)
            ->orderBy('ID desc')
  			->fetchAll();
  	}

    function getVersionIdName($id) {
        return $this->db->select('NAME')
            ->from(self::TABLE_VERSION)
            ->where('ID = ?', $id)
            ->fetchSingle();
    }

    function find($id) {
        return $this->db->select('*')
            ->from(self::TABLE_VERSION)
            ->where('ID = ?', $id)
            ->fetchAll();
    }

    function findVersionData($id) {
        return $this->db->select('*')
            ->from(self::TABLE_VERSIONDATA)
            ->where('ID = ?', $id)
            ->fetch();
    }

    function deleteVersionData($id) {
        return $this->db->delete(self::TABLE_VERSIONDATA)
            ->where('ID = ?', $id)->execute();
    }

    function getListVersionData($id) {
        return $this->db->select('*')
            ->from(self::TABLE_VERSIONDATA)
            ->where('VERSION_ID = ?', $id)
            ->orderBy('LAST_MODIFIED_DATE desc')
            ->fetchAll();
    }

    protected function generateId() {
        return $this->db->query('SELECT MAX(ID)+1 AS new_identity FROM ' . static::TABLE_VERSIONDATA)
            ->fetch()['new_identity'];
    }

    function save($vals) {

        $save = [
            'ID' => $vals['ID'],
            'VERSION_ID' => $vals['VERSION_ID'],
            'ACTIVE' => $vals['ACTIVE'],
            'TITLE' => $vals['TITLE'],
            'LEVEL' => $vals['LEVEL'],
            'DESCRIPTION' => $vals['DESCRIPTION'],
          //  'CREATED_DATE' => $vals['CREATED_DATE'], //při editaci nelze měnit
          //  'CREATED_BY' => $vals['CREATED_BY'], //při editaci nelze měnit
            'LAST_MODIFIED_DATE' => $vals['LAST_MODIFIED_DATE'],
            'LAST_MODIFIED_BY' => $vals['LAST_MODIFIED_BY'],
        ];

        if ($save['ID']){
          $this->db->update(self::TABLE_VERSIONDATA, $save)->where('ID = ?', $vals['ID'])->execute();
        }
        else {
            $save['ID'] = $this->generateId();

            $save['CREATED_BY'] = $vals['CREATED_BY'];
            $save['CREATED_DATE'] = $vals['CREATED_DATE'];

            $this->db->insert(self::TABLE_VERSIONDATA, $save)->execute();

        }
    }

}
