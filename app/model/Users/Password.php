<?php

namespace Lab\Users;

/**
 * Description of Password
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Password {

    /** @var string */
    private $alphabet = 'qwe0rt9yui8op7as6df5ghj4klz3xcv2bn1m';

    /** @var string */
    private $hash = NULL;

    /** @var string */
    private $salt = NULL;

    /**
     *
     * @param string $pass
     * @param string $salt
     * @access public
     */
    public function createHash($pass, $salt) {
        $this->hash = sha1($pass . $salt);
    }

    /**
     *
     * @param int $length
     * @access public
     * @return string
     */
    public function generateSalt($length = 10) {
        $salt = '';
        $cnt = strlen($this->alphabet) - 1;

        for ($i = 0; $i < $length; $i++) {
            $num = rand(0, $cnt);
            $salt .= $this->alphabet[$num];
        }
        $this->salt = $salt;
        return $salt;
    }

    /**
     * getter pro salt hesla
     *
     * @access public
     * @return string
     */
    public function getSalt() {
        return $this->salt;
    }

    /**
     * getter pro vygenerovy hash hesla
     *
     * @access public
     * @return string
     */
    public function getHash() {
        return $this->hash;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

}
