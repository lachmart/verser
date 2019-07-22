<?php

namespace Lab;

use Nette;

class LabUser extends Nette\Object {

    const USER_C = 'user_c';

    /**
     *
     * @var string
     */
    private $alphabet = 'qwe0rt9yui8op7as6df5ghj4klz3xcv2bn1m';

    /**
     * @var \DibiConnection
     */
    protected $db;

    /**
     *
     * @var type
     */
    protected $sess;

    /**
     *
     * @param \DibiConnection $db
     * @param Nette\Http\Session $sess
     */
    function __construct(\DibiConnection $db, Nette\Http\Session $sess) {
        $this->db = $db;
        $this->sess = $sess;
    }

    /**
     * metoda vraci seznam uzivatelu
     */
    function getList() {
        /*
          return $this->db->table('user')
          ->where('IS_DELETED = 0')
          ->order('NAME');
         */
        return $this->db->select('*, ID AS id')
            ->from(self::USER_C)
            ->where('IS_DELETED = 0')
            ->orderBy('NAME')
            ->fetchAll();
    }

    /**
     *
     * @param type $ID
     * @return type
     */
    function getRecord($id) {
        //return $this->db->table('user')->select('ID, NAME, LOGIN, LAB, ROLE')->find($ID)->fetch();
        return $this->db->select('ID, NAME, LOGIN, LAB, ROLE')
            ->from(self::USER_C)
            ->where('ID = ?', $id)
            ->fetch();
    }

    /**
     * autorizace uzivatele
     *
     * @param string $username
     */
    function findByUsername($username) {

        return $this->db->select('*')
            ->from(self::USER_C)
            ->where('LOGIN = ? ', $username)
            ->fetch();
    }

    /**
     *
     */
    function logOut() {
        $this->sess->getSection('labUser')->remove();
    }

    /**
     *
     */
    function getUser() {
        $sessData = $this->sess->getSection('labUser');
        if ($sessData->offsetExists('id')) {
            return $sessData;
        }

        return false;
    }

    /**
     *
     *
     * @param type $vals
     */
    function save($vals) {
        $LABs = array();
        foreach ($vals as $k => $v) {
            $match = array();
            if (preg_match('/^LABS_([a-zA-Z]+)$/i', $k, $match)) {
                if ($v) {
                    $LABs[$match[1]] = $match[1];
                }
                unset($vals[$k]);
            }
        }

        $vals['LAB'] = implode(',', $LABs);

        if ($vals['OLD_ID'] == 0) {
            //insert
            unset($vals['OLD_ID']);
            $vals['SALT'] = $this->generateSalt();
            $pass = sha1($vals['PASS'] . $vals['SALT']);
            $vals['PASS'] = $pass;

            //$this->db->table('user')->insert($vals);
            $this->db->insert(self::USER_C, $vals)
                ->execute();
        } else {
            //update
            $ID = $vals['OLD_ID'];
            unset($vals['OLD_ID']);
            if ($vals['PASS'] == '') {
                unset($vals['PASS']);
            } else {
                $data = $this->db->select('*')
                    ->from(self::USER_C)
                    ->where('ID = ?', $ID)
                    ->fetch();
                $vals['PASS'] = sha1($vals['PASS'] . $data->SALT);
            }
            //$userRow = $this->db->table('user')->get($vals['ID']);
            //$userRow->update($vals);
            $this->db->update(self::USER_C, $vals)->where('ID = ?', $ID)->execute();
        }
    }

    /**
     * metoda ganeruje SALT k heslu
     *
     * @param type $length
     * @return type
     */
    private function generateSalt($length = 10) {
        $salt = '';
        $cnt = strlen($this->alphabet) - 1;

        for ($i = 0; $i < $length; $i++) {
            $num = rand(0, $cnt);
            $salt .= $this->alphabet[$num];
        }

        return $salt;
    }

    /**
     * seznam dostupnych LABoratori
     * @return type
     */
    function getLabs() {
        return array
        (
            'ALL' => 'Všechny Laboratoře FNO',
            'HOK' => 'Hemato-onkologická klinika',
            'LEM' => 'LABoratoř experimentální medicíny',
            'OKB' => 'Oddělení klinické biochemie',
            'FTO' => 'Transfuzní oddělení',
            'IMU' => 'Ústav imunologie',
            'PAT' => 'Ústav klinické a molekulární patologie',
            'GEN' => 'Ústav lékařské genetiky',
            'MIK' => 'Ústav mikrobiologie',
            'USL' => 'Ústav soudního lékařství'
        );
    }

    /**
     *
     * @return array
     */
    function getROLE() {
        return array
        (
            0 => 'Uživatel',
            1 => 'Administrátor'
        );
    }

    /**
     *
     * @param type $ID
     */
    function delete($ID) {
        $ins = array
        (
            'IS_DELETED' => 1
        );
        $this->db->update(self::USER_C, $ins)
            ->where('ID = ?', $ID)
            ->execute();
        //$userRow->delete();
    }

}
