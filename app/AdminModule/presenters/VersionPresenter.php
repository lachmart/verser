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
        $this->template->versionList = $this->version->getListVersion();

        $id = $this->getParameter('id', 0);
        $this->template->id = $this->version->find($id);
        $this->template->versionIdName = $this->version->getVersionIdName($id);        
        $this->template->versionListData = $this->version->getListVersionData($id);
    }

    protected function createComponentVersionDataForm() {

        $form = new UI\Form;

        $form->addHidden('ID');
        $form->addHidden('VERSION_ID');
        $form->addText('ACTIVE', 'Aktivní:');
        $form->addText('LEVEL', 'Úroveň:');
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

    function actionVersionDataForm($vid) {

        $id = $this->getParameter('id', 0);
        $data = $this->version->findVersionData($id);

        $this->template->vid = $vid;

        if ($id != 0) {

//            $data = $this->version->findVersionData($id);

            $this['versionDataForm']->getComponent('ID')->setValue($data->ID);
            $this['versionDataForm']->getComponent('VERSION_ID')->setValue($data->VERSION_ID);
            $this['versionDataForm']->getComponent('ACTIVE')->setValue($data->ACTIVE);
            $this['versionDataForm']->getComponent('LEVEL')->setValue($data->LEVEL);            
            $this['versionDataForm']->getComponent('TITLE')->setValue($data->TITLE);            
            $this['versionDataForm']->getComponent('DESCRIPTION')->setValue($data->DESCRIPTION);
            $this['versionDataForm']->getComponent('CREATED_BY')->setValue($data->CREATED_BY);
            $this['versionDataForm']->getComponent('CREATED_DATE')->setValue($data->CREATED_DATE);
            $this['versionDataForm']->getComponent('LAST_MODIFIED_BY')->setValue($data->LAST_MODIFIED_BY);
            $this['versionDataForm']->getComponent('LAST_MODIFIED_DATE')->setValue($data->LAST_MODIFIED_DATE);

        } else {

  /*
            $this['versionDataForm']->getComponent('VERSION_ID')->setValue($vid);
            $this['versionDataForm']->getComponent('ACTIVE')->setDefaultValue('A');
            $this['versionDataForm']->getComponent('LEVEL')->setDefaultValue('1');;
            $this['versionDataForm']->getComponent('DESCRIPTION')->setDefaultValue('?');;
            $this['versionDataForm']->getComponent('CREATED_BY')->setDefaultValue('1');;
            $this['versionDataForm']->getComponent('CREATED_DATE')->setDefaultValue(date("Y-m-d H:i:s"));
            $this['versionDataForm']->getComponent('LAST_MODIFIED_BY')->setDefaultValue('1');
            $this['versionDataForm']->getComponent('LAST_MODIFIED_DATE')->setDefaultValue(date("Y-m-d H:i:s"));
*/
            $this['versionDataForm']->setDefaults($data);

        }

    }

    function actionDelete($vid) {

        $id = $this->getParameter('id', 0);
        $success =  $this->version->deleteVersionData($id);
        if ($success)
          $this->flashMessage('Záznam odstraněn', 'success');
        else {
          $this->flashMessage('Záznam nebyl odstraněn', 'danger');
        }
        $this->redirect('default', ['id' => $vid] );
    }

    function renderForm() {
        $this->template->h1 = 'Editace obsahu popisu verze';
    }

    public function proceedFormData(UI\Form $versionDataForm) {

        $vals = $versionDataForm->getValues();

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
        $this->redirect('default', ['id' => $vals['VERSION_ID']] );

    }

}
