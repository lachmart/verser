<?php

namespace Lab\Users;

class User {

    const TABLE = 'user_c';

    /** @var \Dibi\Connection */
    private $db;

    function __construct(\Dibi\Connection $db) {
        $this->db = $db;
    }

    function find($id) {
        return $this->db->select('*')
            ->from(self::TABLE)
            ->where('ID = ?', $id)
            ->fetch();
    }

    function getList() {
        return $this->db->select('*')
            ->from(self::TABLE)
            ->fetchAll();
    }

    function save($vals) {

        $password = new Password();

        $save = [
            'NAME' => $vals['NAME'],
            'LOGIN' => $vals['LOGIN'],
            'ROLE' => $vals['ROLE'],
            'LAB' => implode(',', $vals['LABS']),
        ];


        if (!$vals['ID']) {
            //insert
            $save['IS_DELETED'] = 0;
            $save['ID'] = $this->generateId();
            $save['SALT'] = $password->generateSalt();
            $password->createHash($vals['PASS'], $password->getSalt());
            $save['PASS'] = $password->getHash();

            $this->db->insert(self::TABLE, $save)->execute();
        } else {
            $ID = $vals['ID'];
            //update
            if ($vals['PASS'] != '') {
                $data = $this->db->select('*')
                    ->from(self::TABLE)
                    ->where('ID = ?', $ID)
                    ->fetch();
                $save['PASS'] = sha1($vals['PASS'] . $data->SALT);
            }
            $this->db->update(self::TABLE, $save)->where('ID = ?', $vals['ID'])->execute();
        }
    }

    function delete($id) {
        $ins = [
            'IS_DELETED' => 1
        ];
        $this->db->update(self::TABLE, $ins)
            ->where('ID = ?', $id)
            ->execute();
    }

    function recycle($id) {
        $ins = [
            'IS_DELETED' => 0
        ];
        $this->db->update(self::TABLE, $ins)
            ->where('ID = ?', $id)
            ->execute();
    }

    private function generateId() {
        return $this->db->query('SELECT MAX(ID)+1 AS new_identity FROM ' . self::TABLE)
            ->fetch()['new_identity'];
    }

}
