<?php

namespace Lab\AdminModule\Presenters;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /** @var \Lab\Authenticator @inject */
    public $auth;

    /** @var \Dibi\Connection */
    protected $connection;

    /** @var \Krecek5\Config @inject */
    public $config;

    public function beforeRender() {
        parent::beforeRender();
        $this->template->selectedMainMenu = null;
        $this->template->selectedSubMenu = null;
        
        $this->template->editorConfigFileFull = '/inc/ckeditor/fullConfig.js';
//		$this->template->editorConfigFileSimple = '/inc/ckeditor/simpleConfig.js';
        $this->template->editorConfigFileMini = '/inc/ckeditor/miniConfig.js';
        
        $this->template->Krecek5Version = $this->config->getParams()['version'];        
        $this->template->projectDomain = $this->config->getParams()['domain'];
        $this->template->projectCustomer = $this->config->getParams()['customer'];
        $this->template->projectLicence = $this->config->getParams()['licence'];
        $this->template->projectAdminImg = $this->config->getParams()['adminImg'];                        
    }

    /**
     *
     */
    public function startup() {
        parent::startup();

        $this->getUser()->setAuthenticator($this->auth);
        $this->connection = $this->context->getService('dibi.connection');

        $this->template->getLatte()->addFilter('intToYear', '\Krecek\Util\DateUtil::convertIntToYear');

        //prihlaseny uzivatel
        if ($this->getUser()->isLoggedIn()) {

            $this->setLayout('page');
        }
    }

    /**
     * separate logger user identity between modules
     *
     * @return \Nette\Security\Identity
     */
    public function getUser() {
        $user = parent::getUser();
        $user->getStorage()->setNamespace('Lab5Admin');
        return $user;
    }

    /**
     * fasada pro odhlaseni z duvodu dlouhe neaktivity uzivatele
     *
     * @access protected
     */
    protected function logoutIfUserOut() {
        if (!$this->getUser()->isLoggedIn()) {
            if ($this->getUser()->logoutReason === Nette\Http\UserStorage::INACTIVITY) {
                $this->flashMessage('You have been signed out due to inactivity. Please sign in again.',
                    'danger');
            }
            $this->redirect('Sign:in', ['bl' => $this->storeRequest()]);
        }
    }

    /**
     * metoda posila chybu neopravneny uzivatel
     *
     * @access protected
     */
    protected function notAuthorized($permission = null) {
        if ($permission == null || !$this->getUser()->isAllowed($permission[0],
                $permission[1])) {
            $this->error('Sorry, but you don\'t have permission to access this page.',
                403);
            $this->terminate();
        }
    }

}
