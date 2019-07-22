<?php

namespace Lab\FrontModule\Presenters;

use Krecek\Util\DateUtil;

class HomepagePresenter extends BasePresenter {

    /** @var \Lab\Laboratory @inject */
    public $laboratory;

    /** @var \Lab\Users\User @inject */
    public $userRepository;

    public function startup() {
        parent::startup();
    }

    public function renderDefault() {
        $this->template->data = [];

        $this->template->form_labs = $this->laboratory->getListIdName();
        // kategorie vysetreni
        $q_kv = 'SELECT ID, KLIC, N32 FROM nclp_nclptk_c WHERE RACT=\'A\' ORDER BY N32';
        $this->template->form_kv = $this->connection->query($q_kv)->fetchAll();
        //$this->template->form_kv = array_map('utf8_decode', $this->template->form_kv);
        //dump($this->template->form_kv);
//		try{ $this->db->connect(); } catch (Exceltion $e) {dump($e->getMessage());}
//		die();
//		$this->template->form_kv = $this->connection->select('ID, KLIC, N32')
//				->from('NCLP_NCLPTK_C')
//				->where('RACT=\'A\'')
//				->order('N32')
//				->fetchAll();

        $material = new \Krecek\Repository\Material($this->connection);
        $this->template->form_mat = $material->getList();

        $this->redrawControl('labmet');
    }

    function actionReloadData() {
        //setting of datatable view
        //setting of datatable view
        $columns = $this->getParameter('columns');
        $order = $this->getParameter('order');
        $sortBy = \Lab\Util\DataTable::getSort($columns, $order);

        //custom parameters
        $limit = $this->getParameter('length');
        $offset = $this->getParameter('start');
        //render data for view
        $table = new \Krecek\Repository\Table($this->connection,
            $this->link('detail', ['id' => '__ID']));
        $dataCount = $table->getCount($this->getParameter('nazev'),
            $this->getParameter('kategorie'), $this->getParameter('lab'));
        $data = $table->getResult(
            $this->getParameter('nazev'), $this->getParameter('kategorie'),
            $this->getParameter('lab'), $this->getParameter('material'), $limit,
            $offset, $sortBy);
        //output payload
        echo json_encode(array(
            'draw' => 0,
            'recordsTotal' => $dataCount,
            'recordsFiltered' => $dataCount,
            'data' => $data));
        $this->terminate();
    }

    public function renderDetail() {
        $this->template->form_labs = $this->laboratory->getListIdName();
        $table = new \Krecek\Repository\Table($this->connection,
            $this->link('detail', array('id' => '__ID')));
        $metoda = $table->find($this->getParameter('id'));
        //$metoda = $metodaAll[0];
        $this->template->metoda = $metoda;
        $metoda['TAT_TRANSPORT'] = DateUtil::secToHour($metoda['TAT_TRANSPORT']);
        if ($metoda['LAST_MODIFIED_BY'] != null) {
            $this->template->modifiedBy = $this->userRepository->find($metoda['LAST_MODIFIED_BY']);
        } else {
            $this->template->modifiedBy = null;
        }
        $this->template->metoda['INDIKACE'] = strtr(\Str::in($this->template->metoda['INDIKACE']),
            array('\n' => '')); //not functional in template
        $this->template->metoda['POKYNY_ODBER'] = strtr(\Str::in($this->template->metoda['POKYNY_ODBER']),
            array('\n' => '')); //not functional in template           
//        $this->template->metoda['MEDIKACE'] = strtr(\Str::in($this->template->metoda['MEDIKACE']),
//            array('\n' => '')); //not functional in template
            
        $normaly = new \Krecek\Repository\Normaly($this->connection);
        $referable = $normaly->getReferableValue($this->template->metoda['LAB'],
            $this->getParameter('id'));
        $this->template->referable = $referable; // ? $referable->toArray() : $referable;
    }

}
