<?php

namespace Lab\AdminModule\Presenters;

use Nette\Application\UI;

/**
 * @author Petr
 */
class UserPresenter extends BasePresenter {

    /** @var \Lab\Users\User @inject */
    public $user;

    /** @var \Lab\Laboratory @inject */
    public $laboratory;

    function startup() {
        parent::startup();
        $this->logoutIfUserOut();
    }

    function beforeRender() {
        parent::beforeRender();
        $this->template->selectedMainMenu = 'Setting:';
        $this->template->selectedSubMenu = 'User:';
    }

    function renderDefault() {
        $this->template->list = $this->user->getList();
        $this->template->h1 = 'Přehled uživatelů';
    }

    function actionForm() {
        $id = $this->getParameter('id', 0);
        $this['form']->getComponent('ROLE')->setItems(\Lab\Users\Role::getData());
        $this['form']->getComponent('LABS')->setItems(['ALL' => '--- vše ---'] + $this->laboratory->getListIdName());

        if ($id == 0) {
            $this['form']->getComponent('PASS')->setRequired('Vyplňte pole Heslo');
        } else {
            $data = $this->user->find($id);
            $this['form']->getComponent('LABS')->setValue(explode(',', $data->LAB));
            $this['form']->setDefaults($data);
        }
    }

    function renderForm() {
        $this->template->h1 = 'Editace uživatele';
    }

    protected function createComponentForm() {
        $form = new UI\Form;

        $form->addHidden('ID');
        $form->addText('NAME', 'Jméno a příjmení')
            ->setRequired('Vložte jméno a příjmení uživatele');
        $form->addText('LOGIN', 'Přihlašovací jméno')
            ->setRequired('Vložte přihlašovací jméno uživatele');
        $form->addPassword('PASS', 'Heslo');
        $form->addSelect('ROLE', 'Role');

        $form->addCheckboxList('LABS', 'Přístup k');

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = [$this, 'proceedFormData'];

        return $form;
    }

    function proceedFormData(UI\Form $form) {
        $vals = $form->getValues();
        $this->user->save($vals);
        $this->flashMessage('Uživatel byl uložen', 'success');
        $this->redirect('default');
    }

    function renderProfile() {
        $this->template->userObj = $this->user->find($this->getUser()->getId());
        $this->template->h1 = 'Profil uživatele';
    }

    function actionDelete() {
        $id = $this->getParameter('id', 0);
        $this->user->delete($id);
        $this->flashMessage('Záznam byl odstraněn', 'success');
        $this->redirect('default');
    }

    function actionRecycle() {
        $id = $this->getParameter('id', 0);
        $this->user->recycle($id);
        $this->flashMessage('Záznam byl změněn', 'success');
        $this->redirect('default');
    }

}
