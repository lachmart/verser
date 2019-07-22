<?php

namespace Lab\AdminModule\Presenters;

use Nette\Application\UI;

/**
 * @author Petr
 */
class LaboratoryPresenter extends BasePresenter {

    /** @var \Lab\Laboratory @inject */
    public $laboratory;

    function startup() {
        parent::startup();
        $this->logoutIfUserOut();
    }

    function beforeRender() {
        parent::beforeRender();
        $this->template->selectedMainMenu = 'Setting:';
        $this->template->selectedSubMenu = 'Laboratory:';
    }

    function renderDefault() {
        $this->template->list = $this->laboratory->getList();
        $this->template->h1 = 'Přehled laboratoří';
    }

    function actionForm() {
        $id = $this->getParameter('id', null);

        if ($id) {
            $data = $this->laboratory->find($id);

            $this['form']->getComponent('OLD_KOD')->setValue($data->KOD);
            $this['form']->getComponent('KOD')->setAttribute('readonly', 'readonly');
            $this['form']->setDefaults($data);
        }
    }

    function renderForm() {
        $this->template->h1 = 'Editace laboratoře';
    }

    function actionDelete() {
        $id = $this->getParameter('id', '');
        $this->laboratory->delete($id);
        $this->flashMessage('Záznam byl odstraněn', 'success');
        $this->redirect('default');
    }

    function actionRecycle() {
        $id = $this->getParameter('id', '');
        $this->laboratory->recycle($id);
        $this->flashMessage('Záznam byl změněn', 'success');
        $this->redirect('default');
    }

    protected function createComponentForm() {
        $form = new UI\Form;

        $form->addHidden('OLD_KOD');

        $form->addText('KOD', 'ID laboratoře')
            ->setRequired('Vložte ID laboratoře')
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 5);

        $form->addText('NAME', 'Název pracoviště')
            ->setRequired('Vložte název laboratoře')
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 100);

        $form->addText('ODD', 'Oddělení')
            ->setRequired('Vložte název oddělení')
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 50);

        $form->addText('KONTAKT', 'Kontaktní osoba')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 30);

        $form->addText('TEL', 'Telefon')
            ->setRequired('Vložte telefon')
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 30);

        $form->addText('EMAIL', 'E-mail')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 30);

        $form->addText('WWW', 'WWW')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 100);

        $form->addText('ADDRESS', 'Adresa')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 50);

        $form->addText('CODE', 'PSČ')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 6);

        $form->addText('ZIP', 'Pošta')
            ->setRequired(false)
            ->addRule(UI\Form::MAX_LENGTH, 'Pole může obsahovat maximálně %d znaků', 30);

        $form->addSubmit('send', 'Uložit');

        $form->onSubmit[] = [$this, 'proceedFormData'];

        return $form;
    }

    function proceedFormData(UI\Form $form) {
        $vals = $form->getValues();
        $this->laboratory->save($vals);
        $this->flashMessage('Záznam byl uložen', 'success');
        $this->redirect('default');
    }

}
