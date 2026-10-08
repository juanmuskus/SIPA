
<?php
class LogoutController extends Zend_Controller_Action{
     private $em;

    public function init(){
        /* Initialize action controller here */
        
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
        $this->_helper->layout->setLayout('admin');
        $this->_helper->layout->setLayout('layout');
        $this->_helper->layout->setLayout('prueba');
    }

    public function indexAction(){
    //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
    $this->_helper->viewRenderer->setNoRender(TRUE); 
       
        $authNamespace = new Zend_Session_Namespace('Zend_Auth');
        unset($authNamespace);
       // $authNamespace->setExpirationSeconds('60');
        $this->_helper->redirector->goToUrl('/login');
    }


}
