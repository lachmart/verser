<?php

namespace Lab;

/**
 * Description of Laboratory
 *
 * @author Petr
 */
class Laboratory {

    const TABLE = 'laboratory';

    /** @var \Dibi\Connection */
    private $db;

    function __construct(\Dibi\Connection $db) {
        $this->db = $db;
    }

    function find($id) {
        return $this->db->select('*')
            ->from(self::TABLE)
            ->where('KOD = ?', $id)
            ->fetch();
    }

    function getListIdName() {
        return $this->db->select('*')
            ->from(self::TABLE)
            ->where('IS_DELETED = ?', '0')            
            ->fetchPairs('KOD', 'NAME');
    }

    function getList() {
        return $this->db->select('*')
            ->from(self::TABLE)
            ->fetchAll();
    }

    function save($vals) {

        $row = $this->find($vals['OLD_KOD']);

        if (!$row) {
            unset($vals['OLD_KOD']);
            $this->db->insert(self::TABLE, $vals)->execute();
        } else {
            $update = ['NAME' => $vals['NAME']];
            $update = ['ODD' => $vals['ODD']];
            $update = ['KONTAKT' => $vals['KONTAKT']];
            $update = ['TEL' => $vals['TEL']];
            $update = ['EMAIL' => $vals['EMAIL']];
            $update = ['WWW' => $vals['WWW']];
            $update = ['ADDRESS' => $vals['ADDRESS']];
            $update = ['CODE' => $vals['CODE']];
            $update = ['ZIP' => $vals['ZIP']];            
            
            $this->db->update(self::TABLE, $update)->where('KOD = ?', $vals['KOD'])->execute();
        }
    }

    function delete($id) {
        $ins = [
            //todo check DB structure
            'IS_DELETED' => 1
        ];
        $this->db->update(self::TABLE, $ins)
            ->where('KOD = ?', $id)
            ->execute();
    }

    function recycle($id) {
        $ins = [
            'IS_DELETED' => 0
        ];
        $this->db->update(self::TABLE, $ins)
            ->where('KOD = ?', $id)
            ->execute();
    }

}
