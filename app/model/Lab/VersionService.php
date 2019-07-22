<?php

namespace Lab;

class Version
{
    const TABLE_VERSION = 'version';
    const TABLE_VERSIONDATA = 'version_data';
   
    /** @var \DibiConnection */
	private $db;

    public function __construct(\Dibi\Connection $db) {
        $this->db = $db;
        //$this->user = $user;
    }

    function getList() {
//  		return $this->db->select('ID, NAME, ACTIVE, RELEASE_DATE')
  		return $this->db->select('*')
            ->from(self::TABLE_VERSION)
  			->where('SYS_ID = 1 and ACTIVE = 1')
            ->orderBy('ID desc')  			
  			->fetchAll();
  	}  	

    function find($id) {
        return $this->db->select('*')
            ->from(self::TABLE_VERSION)
            ->where('ID = ?', $id)
            ->fetch();
    }

    function findVersionData($id) {
        return $this->db->select('*')
            ->from(self::TABLE_VERSIONDATA)
            ->where('ID = ?', $id)
            ->fetch();
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
            'LEVEL' => $vals['LEVEL'],
            'DESCRIPTION' => $vals['DESCRIPTION'],
            'CREATED_DATE' => $vals['CREATED_DATE'],
            'CREATED_BY' => $vals['CREATED_BY'],
            'LAST_MODIFIED_DATE' => $vals['LAST_MODIFIED_DATE'],
            'LAST_MODIFIED_BY' => $vals['LAST_MODIFIED_BY'],
        ];

        if (!$vals['ID']) {

            $save['ID'] = $this->generateId();
            $save['VERSION_ID'] = 1;
            $save['ACTIVE'] = 'A';
            $save['LEVEL'] = '1';
            $save['DESCRIPTION'] = '???';            

            $this->db->insert(self::TABLE_VERSIONDATA, $save)->execute();
            
        } else {
            
            $ID = $vals['ID'];
            $VERSION_ID = $vals['VERSION_ID'];            
            $ACTIVE = $vals['ACTIVE'];
            $LEVEL = $vals['LEVEL'];
            $DESCRIPTION = $vals['DESCRIPTION'];

            $this->db->update(self::TABLE_VERSIONDATA, $save)->where('ID = ?', $vals['ID'])->execute();
        }
    }


}
