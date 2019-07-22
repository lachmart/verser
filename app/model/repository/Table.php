<?php

namespace Krecek\Repository;

/**
 * Description of Table
 *
 * @author Petr Kobelka <info@petrkobelka.cz>
 */
class Table {

    /** @var \Dibi\Connection */
    private $db;
    private $link;

    function __construct(\DibiConnection $db, $link) {
        $this->db = $db;
        $this->link = $link;
    }

    function getCount($nazev, $kategorie, $lab) {
        $q = 'SELECT COUNT(*) AS POCET ' .
            'FROM tabule ' .
            'WHERE RACT=\'A\' AND STAV=\'1\' ';
        if ($nazev != '') {
            $q .= ' AND NAZEV LIKE \'%' . $nazev . '%\' ';
        }
        if ($lab != '' && $lab != 'ALL') {
            $q .= ' AND LAB = \'' . $lab . '\' ';
        }
        if ($kategorie != '') {
            $q .= ' AND NCLPTK = \'' . $kategorie . '\' ';
        }
        return $this->db->query($q)->fetch()->toArray()['POCET'];
    }

    function getResult($nazev, $kategorie, $lab, $material, $limit = 10,
                       $offset = 0, $sortBy = []) {
        $q = 'SELECT tabule.LAB, '
            . 'tabule.NAZEV, '
            . 'tabule.ID, '
            . 'tabule.ZKRATKA, '
            . 'tabule.STATIM, '
//            . 'tabule.NCLPTK, '
            . 'nclp_nclpmat_c.N55 AS NCLPMAT, '
//            . 'CONCAT(nclp_nclponp_c.OZNACENI, nclp_nclponp_c.N55) AS NCLPONP ' .
            . 'nclp_nclponp_c.OZNACENI AS OZNACENI, '
            . 'nclp_nclponp_c.N55 AS NCLPONP ' .
            'FROM tabule ' .
            'LEFT JOIN nclp_nclpmat_c ON tabule.NCLPMAT = nclp_nclpmat_c.KLIC ' .
            'LEFT JOIN nclp_nclponp_c ON tabule.NCLPONP = nclp_nclponp_c.KLIC ' .
            'WHERE tabule.RACT=\'A\' AND tabule.STAV = \'1\' ';

        if ($nazev != '') {
            $q .= ' AND tabule.NAZEV LIKE \'%' . $nazev . '%\' ';
        }
        if ($lab != '' && $lab != 'ALL') {
            $q .= ' AND tabule.LAB = \'' . $lab . '\' ';
        }
        if ($kategorie != '') {
            $q .= ' AND tabule.NCLPTK = \'' . $kategorie . '\' ';
        }
        if ($material != '') {
            $q .= ' AND tabule.NCLPMAT = \'' . $material . '\' ';
        }

        if (!$sortBy) {
            $q .= ' ORDER BY NAZEV ASC ';
        } else {
            $count = count($sortBy);
            $q .= ' ORDER BY ';
            foreach ($sortBy as $sKey => $sName) {
                $q .= $sKey . ' ' . $sName;
                if (--$count > 0) {
                    $q .= ', ';
                }
            }
        }
        $q .= ' LIMIT ' . $offset . ', ' . $limit . ' ';

        $data = $this->db->query($q)->fetchAll();

        foreach ($data as $k => $d) {
            $data[$k]['STATIM'] = self::resolveStatim($d['STATIM']);
            //sprintf($this->link, $d['ID'])
//            $data[$k]['NAZEV'] = '<a href="' . strtr($this->link, ['__ID' => $d['ID']]) . '">' . $d['NAZEV'] . ' [' . $d['ZKRATKA'] . ']</a>';
            $data[$k]['NAZEV'] = '<a href="' . strtr($this->link, ['__ID' => $d['ID']]) . '">'.$d['NAZEV'].'</a>';
        }

        return $data;
    }

    function find($id) {
        $q = 'SELECT ID, '
            . 'LAB, '
            . 'NAZEV, '
            . 'NAZEV1, '
            . 'ZKRATKA, '     //5
            . 'JEDNOTKA, '
            . 'MATERIAL, '
            . 'POKYNY_ODBER, '
            . 'ODB_MNOZSTVI, '
            . 'TAT_TRANSPORT, ' //10
            . 'TAT_LAB, ' 
            . 'TAT_TEPLOTA, '
            . 'TAT_TEPLOTA_DO, '
            . 'HODNOCENI, '
            . 'INDIKACE, '      //15
            . 'SYNONYMA, '      
            . 'STATIM, '
            . 'DOSTUPNOST, '
            . 'DOSTUPNOST_S, '
            . ' (SELECT N20 FROM nclp_nclpjedn_c WHERE KLIC=tabule.NCLPJEDN) AS NCLPJEDN, ' 
            . ' (SELECT N55 FROM nclp_nclpmat_c WHERE KLIC=tabule.NCLPMAT) AS NCLPMAT, '    //20
            . ' (SELECT N55 FROM nclp_nclponp_c WHERE KLIC=tabule.NCLPONP) AS NCLPONP,'
            . ' (SELECT N55 FROM nclp_nclpproc_c WHERE KLIC=tabule.NCLPPROC) AS NCLPPROC,'
            . ' (SELECT N55 FROM nclp_nclpsyst_c WHERE KLIC=tabule.NCLPSYST) AS NCLPSYST,'
            . ' (SELECT N55 FROM nclp_nclptk_c WHERE KLIC=tabule.NCLPTK) AS NCLPTK,'
            . ' (SELECT N55 FROM nclp_nclpdrvl_c WHERE KLIC=tabule.NCLPDRVL) AS NCLPDRVL,'   //25               
            . 'VYSLEDEK_1, '        
            . 'VYSLEDEK_1_TYP, '
            . 'VYSLEDEK_S, '
            . 'VYSLEDEK_S_TYP, '
            . 'VYSLEDEK_V, '        //30
            . 'VYSLEDEK_V_TYP, '    
            . 'DOORDINACE, '
            . 'ST_ANAL_TEMP1, '
            . 'ST_ANAL_TYP1, '
            . 'ST_ANAL_TEMP2, '     //35
            . 'ST_ANAL_TYP2, '      
            . 'ST_ANAL_TEMP3, '
            . 'ST_ANAL_TYP3, '
            . 'ST_ANAL_TEMP4, '
            . 'ST_ANAL_TYP4, '      //40
            . 'DOORDINACE, '        
            . 'CREATED_DATE, '
            . 'CREATED_BY, '
            . 'IS_ISO, '            
            . 'IS_EXTERNAL, '       //45
            . 'IS_VAV, '            
            . 'IS_NOT_TUBEMAIL, '
            . 'NEJISTOTA, '
            . 'REFINT_ZDROJ, '      
            . 'VARIABILITA, '       //50
            . 'NCLP_POL_KLIC, '     
            . 'POPIS, '
            . 'LAST_MODIFIED_DATE, '
            . 'LAST_MODIFIED_BY, '  
            . 'POZNAMKA, '          //55
            . 'INTERFER_JINE, '            
            . 'UNIVER, '
            . 'POKYNY_ODBER, '
            . 'POKYNY_TRANSPORT, '
            . 'POKYNY_PACIENT, '       //60
            . 'POLOCAS, '                                                         
            . 'POZN '
            . ' FROM tabule '
            . ' WHERE tabule.ID = ' . intval($id) . ' ';

        return $this->db->query($q)->fetch();
    }

    public static function resolveStatim($statim) {
        if ($statim == 0) {
			return 'RUTINA';
//            return '<img src="../images/rutina.png" border="0" title="R U T I N A !"/>';
        }
        if ($statim == 1) {
			return 'RUTINA + STATIM';
//            return '<img src="../images/rutina.png" border="0" title="R U T I N A !"/>&nbsp;<img src="../images/statim.png" border="0" title="S T A T I M !"/>';
        }
        if ($statim == 2) {
			return 'RUTINA + STATIM + VITAL';
//            return '<img src="../images/rutina.png" border="0" title="R U T I N A !"/>&nbsp;<img src="../images/statim.png" border="0" title="S T A T I M !"/>&nbsp;<img src="../images/vital.png" border="0" title="V I T A L !"/>';
        }
        return '';
    }

    public static function resolveStAnal($stanal) {
        if ($stanal == 'I') {
            return 'minuta';
        }
        if ($stanal == 'H') {
            return 'hodina';
        }
        if ($stanal == 'D') {
            return 'den';
        }
        if ($stanal == 'W') {
            return 'týden';
        }
        if ($stanal == 'M') {
            return 'měsíc';
        }
        if ($stanal == 'Y') {
            return 'rok';
        }
        if (($stanal == '') || ($stanal == 'X') || ($stanal == NULL)) {
            return 'neuvedeno';
        }
        return '';
    }

    public static function resolveDostupnost($dostupnost) {
        if ($dostupnost == 'D') {
            return 'denně';
        }
        if ($dostupnost == 'W') {
            return 'týdně';
        }
        if ($dostupnost == 'M') {
            return 'měsíčně';
        }
        if ($dostupnost == '1') {
            return 'pondělí';
        }
        if ($dostupnost == '2') {
            return 'úterý';
        }
        if ($dostupnost == '3') {
            return 'středa';
        }
        if ($dostupnost == '4') {
            return 'čtvrtek';
        }
        if ($dostupnost == '5') {
            return 'pátek';
        }
        if ($dostupnost == 'A') {
            return 'pondělí a středa a pátek';
        }
        if ($dostupnost == 'B') {
            return 'úterý a čtvrtek';
        }
        if ($dostupnost == 'C') {
            return 'pondělí a čtvrtek';
        }
        if ($dostupnost == 'Y') {
            return 'pondělí až pátek';
        }
        if ($dostupnost == 'X') {
            return 'domluva';
        }
        if (($dostupnost == '') || ($dostupnost == NULL)) {
            return 'neuvedeno';
        }
        return '';
    }

}
