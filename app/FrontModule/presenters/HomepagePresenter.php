<?php

namespace Lab\FrontModule\Presenters;

use Nette\Application\UI;
use Nette\Forms;

/**
 * @author J
 */
class HomepagePresenter extends BasePresenter {

    /** @var \Version\Version @inject */
    public $version;

    function startup() {
        parent::startup();
//        $this->logoutIfUserOut();
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

        $this->template->versionListData = $this->version->getListVersionData($id);
    }

}
