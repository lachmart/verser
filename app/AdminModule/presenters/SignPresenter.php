<?php

namespace Lab\AdminModule\Presenters;

use Nette\Application\UI;

class SignPresenter extends BasePresenter {

    /**  @var \Lab\LabUser @inject */
    public $labUser;

    /**
     *
     */
    public function startup() {
        parent::startup();
        $this->setLayout('login');
    }

    /**
     * Sign-in form factory.
     * @return \Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new UI\Form;
        $form->addText('username', 'Přihlašovací jméno:')
            ->setRequired('Prosím, vložte své přihlašovací jméno.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Prosím, vložte heslo.');

        //$form->addCheckbox('remember', 'Keep me signed in');

        $form->addSubmit('submit', 'Přihlásit');

        // call method signInFormSucceeded() on success
        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }

    /**
     *
     * @param type $form
     */
    public function signInFormSucceeded($form) {
        $values = $form->getValues();

        try {
            $this->getUser()->login($values->username, $values->password);
        } catch (\Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
            $form->addError('The username or password you entered is incorrect.');
        }

//		if ($this->labUser->authorize($values)) {
//			//ok
//			$this->flashMessage('Přihlášení proběhlo v pořádku', 'success');
//			$this->redirect('Homepage:');
//		}
//		else {
//			//chyba
//			$this->flashMessage('Neplatné přihlašovací jméno, nebo heslo.', 'error');
//			$this->redirect('in');
//		}

        //$this->flashMessage('Přihlášení proběhlo v pořádku', 'success');
        $this->redirect('Version:');

    }

    /**
     *
     */
    public function actionOut() {
        //$data = $this->getUser();
        $this->labUser->logOut();
        $this->flashMessage('Byli jste úspěšně odhlášeni.');
        $this->redirect('in');
    }

}
