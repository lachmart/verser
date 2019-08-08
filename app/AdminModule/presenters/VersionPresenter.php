<?php

namespace Lab\AdminModule\Presenters;

use Nette\Application\UI;
use Nette\Forms;

/**
 * @author J
 */
class VersionPresenter extends BasePresenter {

    /** @var \Version\Version @inject */
    public $version;

    function startup() {
        parent::startup();
        $this->logoutIfUserOut();
    }

    function beforeRender() {
        parent::beforeRender();
        $this->template->selectedMainMenu = 'Version:';
    }

    function renderDefault() {

        $this->template->h1 = 'Popisy verzí';

        $this->template->systemList = $this->version->getListSystem();

        $sid = $this->getParameter('sid', 0);
        $this->template->sid = $sid;
        $this->template->versionList = $this->version->getListVersion($sid);


        $vid = $this->getParameter('vid', 0);
        $this->template->vid = $vid;
        $this->template->versionIdName = $this->version->getVersionIdName($vid);
        $this->template->versionListData = $this->version->getListVersionData($vid);
    }

    protected function createComponentVersionDataForm() {

        $form = new UI\Form;

        $form->addHidden('ID');
        $form->addHidden('VERSION_ID');
        $form->addHidden('SYS_ID', 'Systém:');
        //$form->addText('ACTIVE', 'Aktivní:');
        $form->addSelect('ACTIVE', 'Aktivní:', [
            '0' => 'Ne',
            'A' => 'Ano',
        ]);
        $form['ACTIVE']->setDefaultValue('0');

        $form->addSelect('LEVEL', 'Úroveň:', [
            '0' => 'Veřejný',
            '1' => 'Privátní',
        ]);
        $form['ACTIVE']->setDefaultValue('0');

        //$form->addText('LEVEL', 'Úroveň:');
        $form->addText('TITLE', 'Titulek popisu:');
        $form->addTextArea('DESCRIPTION', 'Popis verze');
        $form->addText('CREATED_BY', 'Vytvořil:');
        $form->addText('CREATED_DATE', 'Dne:');
        $form->addText('LAST_MODIFIED_BY', 'Aktualizoval:');
        $form->addText('LAST_MODIFIED_DATE', 'Aktualizace:');

        $form->addSubmit('submit', 'Uložit data');
//        $form->addSubmit('cancel', 'Návrat zpět');

        $form->onSuccess[] = [$this, 'proceedFormData'];

        return $form;

    }

    function actionVersionDataForm($vid, $sid) {

        $id = $this->getParameter('id', 0);
        //$data = $this->version->findVersionData($id);
        $this->template->vid = $vid;
        $this->template->sid = $sid;


        if ($id != 0) {

            $data = $this->version->findVersionData($id);
            $this['versionDataForm']->setDefaults([
              'ID'=>$data->ID,
              'VERSION_ID'=>$data->VERSION_ID,
              'SYS_ID'=>$sid,
              'ACTIVE'=>$data->ACTIVE,
              'LEVEL'=>$data->LEVEL,
              'TITLE'=>$data->TITLE,
              'DESCRIPTION'=>$data->DESCRIPTION,
              'CREATED_BY'=>$data->CREATED_BY,
              'CREATED_DATE'=>$data->CREATED_DATE,
              'LAST_MODIFIED_BY'=>$data->LAST_MODIFIED_BY,
              'LAST_MODIFIED_DATE'=>$data->LAST_MODIFIED_DATE,
            ]);
        } else {

            $this['versionDataForm']->setDefaults([
              'VERSION_ID'=>$vid,
              'SYS_ID'=>$sid,
              //'ACTIVE' => '0',
              'CREATED_BY' => $this->getUser()->getIdentity()->id,
              'CREATED_DATE'=>date("Y.m.d"),
              'LAST_MODIFIED_BY'=> $this->getUser()->getIdentity()->id,
              'LAST_MODIFIED_DATE'=>date("Y.m.d"),
            ]);

        }

    }

    function actionDelete($vid, $sid) {

        $id = $this->getParameter('id', 0);
        $success =  $this->version->deleteVersionData($id);
        if ($success)
          $this->flashMessage('Záznam odstraněn', 'success');
        else {
          $this->flashMessage('Záznam nebyl odstraněn', 'danger');
        }
        $this->redirect('default', ['vid' => $vid,'sid' => $sid] );
    }

    function renderForm() {
        $this->template->h1 = 'Editace obsahu popisu verze';
    }

    public function proceedFormData(UI\Form $versionDataForm) {

        $vals = $versionDataForm->getValues();
        $vals['LAST_MODIFIED_BY']=$this->getUser()->getIdentity()->id;
		try {

			  $this->version->save($vals);

			//$this->sendConfirmEmail($vals['event_id'], $vals);

        $this->flashMessage('Záznam popisu verze byl uložen', 'success');
		}
		catch (\Exception $e) {
			$this->flashMessage($e->getMessage(), 'danger');
		}
      //print_r($vals);
      //$this->redirect('default');
        $this->redirect('default', ['vid' => $vals['VERSION_ID'],'sid' => $vals['SYS_ID'] ] );

    }

}
